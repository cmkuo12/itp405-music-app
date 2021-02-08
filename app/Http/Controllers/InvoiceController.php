<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = DB::table('invoices')
            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->get([
                'invoices.id AS id',
                'invoice_date',
                'first_name',
                'last_name',
                'total'
            ]);

            // sql translation:
            // SELECT invoices.id AS id, invoice_date, first_name, last_name, total
            // FROM invoices
            // INNER JOIN customers ON invoices.customer_id = customers.id

        return view('invoice.index', [
            'invoices' => $invoices //variable passed along to view
        ]);
    }

    public function show($id)
    {
        $invoice = DB::table('invoices')
            ->where('id', '=', $id)
            ->first(); //don't want array of things, just the single object

        $invoiceItems = DB::table('invoice_items')
            ->where('invoice_id', '=', $id)
            ->join('tracks', 'invoice_items.track_id', '=', 'tracks.id')
            ->join('albums', 'tracks.album_id', '=', 'albums.id')
            ->join('artists', 'albums.artist_id', '=', 'artists.id')
            ->get([
                'invoice_items.unit_price',
                'tracks.name AS track',
                'albums.title AS album',
                'artists.name AS artist'
            ]);

        return view('invoice.show', [
            'invoice' => $invoice,
            'invoiceItems' => $invoiceItems
        ]);
    }
}
