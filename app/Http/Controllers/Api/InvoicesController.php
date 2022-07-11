<?php

namespace App\Http\Controllers\Api;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

/**
 * The Invoice object.
 */
class InvoicesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *   The request object.
     *
     * @return \Illuminate\View\View
     *   Returns the view object.
     */
    public function store(Request $request)
    {
        $company = $this->getCompanyInfo();
        $details = $request->all();
        if (!empty($details)) {
            $items = [];
            foreach ($details as $key => $value) {
                if ('description' == substr($key, 0, 11)) {
                    $items[$key] = $value;
                }
                if ('amount' == substr($key, 0, 6)) {
                    $items[$key] = $value;
                }
                if ('is_taxed' == substr($key, 0, 8)) {
                    $items[$key] = $value;
                }
            }
            DB::insert('insert into `invoices` (items) values (?);', [
                json_encode($items)
            ]);
            $id = DB::select('select id from `invoices` order by id desc limit 1;');
            $invoice_id = $id[0]->id;
            DB::insert('insert into `customers` (invoice_id, billing_name, company_name,
            street_address, city, area_code, phone_number) values (?, ?, ?, ?, ?, ?, ?);', [
                $invoice_id,
                $details['billing_name'],
                $details['company_name'],
                $details['street_address'],
                $details['city'],
                $details['area_code'],
                $details['phone_number']
            ]);
            $comments = $details['comments'];
            if (!empty($comments)) {
                DB::insert('insert into `comments` (invoice_id, comments) values (?, ?);', [
                    $invoice_id,
                    $comments
                ]);
            }
            $date = date('d/m/Y');
            $company = $this->getCompanyInfo();
            $data = $this->getInvoiceData($invoice_id);
            $due_date = date('d/m/Y', strtotime('+1 year'));
            $invoice_items = json_decode($data['invoice']->items, true);
            $items = $this->getItemParts($invoice_items);
            $caculations = $this->getCalculations($company[0]->tax_rate, $invoice_items);
            return view('preview', [
                'invoice_id' => $data['invoice']->id,
                'customer' => $data['customer'],
                'comments' => $data['comments'],
                'calculated' => $caculations,
                'company' => $company[0],
                'invoices' => $items,
                'due' => $due_date,
                'date' => $date,
            ]);
        }
    }

    /**
     * Prepares the invoice items.
     * 
     * @param array $items
     *   The items array to iterate.
     *
     * @return array
     *   Returns an assoc array of items.
     */
    public function getItemParts($items) {
        $items_counter = count($items) / 3;
        $item_parts = [];
        if ($items_counter > 1) {
            $item_parts[0]['description'] = $items['description'];
            if (isset($items['is_taxed'])) {
                $item_parts[0]['is_taxed'] = $items['is_taxed'];
            }
            else {
                $item_parts[0]['is_taxed'] = 'off';
            }
            $item_parts[0]['amount'] = number_format($items['amount'], 2, '.', '');
            $items_counter = $items_counter - 1;
            for ($i = 0; $i < $items_counter; $i++) {
                $key = $i + 1;
                $item_parts[$key]['description'] = $items['description_' . $i];
                if (isset($items['is_taxed_' . $i])) {
                    $item_parts[$key]['is_taxed'] = $items['is_taxed_' . $i];
                }
                else {
                    $item_parts[$key]['is_taxed'] = 'off';
                }
                $item_parts[$key]['amount'] = number_format($items['amount_' . $i], 2, '.', '');
            }
        }
        else {
            $item_parts[0]['description'] = $items['description'];
            if (isset($items['is_taxed'])) {
                $item_parts[0]['is_taxed'] = $items['is_taxed'];
            }
            else {
                $item_parts[0]['is_taxed'] = 'off';
            }
            $item_parts[0]['amount'] = number_format($items['amount'], 2, '.', '');
        }
        return $item_parts;
    }

    /**
     * Generates the invoicec pdf document.
     *
     * @param int $id
     *   The invoice id.
     *
     * @return void
     */
    public function generatePDF($id)
    {
        $date = date('d/m/Y');
        $data = $this->getInvoiceData($id);
        $company = $this->getCompanyInfo();
        $due_date = date('d/m/Y', strtotime('+1 year'));
        $invoice_items = json_decode($data['invoice']->items, true);
        $items = $this->getItemParts($invoice_items);
        $caculations = $this->getCalculations($company[0]->tax_rate, $invoice_items);
        $pdf = PDF::loadView('preview', [
            'invoice_id' => $data['invoice']->id,
            'customer' => $data['customer'],
            'comments' => $data['comments'],
            'calculated' => $caculations,
            'company' => $company[0],
            'invoices' => $items,
            'due' => $due_date,
            'date' => $date,
        ]);
        return $pdf->download('invoice_' . time() . '.pdf');
    }

    /**
     * Fetches all historic invoices.
     *
     * @return \Illuminate\View\View
     *   Returns the view object.
     */
    public function getAllInvoices() {
        $invoices = DB::select('select * from invoices
        JOIN customers ON invoices.id = customers.invoice_id 
        JOIN comments ON invoices.id = comments.invoice_id;');
        return view ('list', compact('invoices'));   
    }

    /**
     * Selects all company information.
     * 
     * @return array
     *   Returns an array of company details.
     */
    public function getCompanyInfo()
    {
        return DB::select('select * from company;', [1]);
    }

    /**
     * Fetches invoice data from the db.
     * 
     * @param int $invoice_id
     *   The invoice id.
     * 
     * @return array
     *   Returns an assoc array of invoice data.
     */
    public function getInvoiceData($invoice_id) 
    {
        $invoice_data = DB::select('select * from invoices where id = ?;', [
            $invoice_id
        ]);
        $customer_details = DB::select('select * from customers where invoice_id = ?;', [
            $invoice_id
        ]);
        $comments = DB::select('select * from comments where invoice_id = ?;', [
            $invoice_id
        ]);
        return [
            'invoice' => $invoice_data[0], 
            'customer' => $customer_details[0],
            'comments' => $comments[0] ?? NULL,
        ];
    }

    /**
     * Calculates the invoice amounts.
     * 
     * @param float $tax_rate
     *   The VAT rate.
     * @param array $items
     *   The invoice items list.
     * 
     * @return array
     *   Returns an assoc array of calculated data.
     */
    public function getCalculations($tax_rate, $items)
    {
        $items_counter = count($items) / 3;
        if ($items_counter > 1) {
            $sub_total = $items['amount'];
            $items_counter = $items_counter - 1;
            $taxable = 0;
            if (isset($items['is_taxed'])) {
                $taxable += $items['amount'];
            }
            for ($i = 0; $i < $items_counter; $i++) {
                $sub_total += $items['amount_' . $i];
                if (isset($items['is_taxed_' . $i])) {
                    $taxable += $items['amount_' . $i];
                }
            }
            if ($taxable > 0) {
                $tax_due = $taxable * $tax_rate;
            }
            $total = $sub_total + $tax_due;
        }
        else {
            $sub_total = $items['amount'] + $items['amount_0'];
            $taxable = 0;
            if ($items['is_taxed'] == 'on') {
                $taxable = $items['amount'];
            }
            if ($taxable > 0) {
                $tax_due = $taxable * $tax_rate;
            }
            $total = $sub_total + $tax_due;
        }
        return [
            'sub_total' => number_format($sub_total, 2, '.', ''),
            'taxable' => number_format($taxable, 2, '.', ''),
            'tax_rate' => $tax_rate,
            'tax_due' => number_format($tax_due, 2, '.', ''),
            'total' => number_format($total, 2, '.', ''),
        ];
    }
}
