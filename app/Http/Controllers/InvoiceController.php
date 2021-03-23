<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Invoice;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Invoice::class); //pick up InvoicePolicy (class indicates), use viewAny method
        //ELOQUENT METHOD
        //$invoices = Invoice::all(); //Suffers from the N+1 problem
        //$invoices = Invoice::with(['customer'])->get(); //eager loading

        $invoices = Invoice::select('invoices.*') //use invoices table
            ->with(['customer']) //eager load customer
            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->when(!Auth::user()->isAdmin(), function($query) {
                return $query->where('customers.email', '=', Auth::user()->email);
            })
            ->get();

        //DB QUERYING METHOD
        // $invoices = DB::table('invoices')
        //     ->join('customers', 'invoices.customer_id', '=', 'customers.id')
        //     ->get([
        //         'invoices.id AS id',
        //         'invoice_date',
        //         'first_name',
        //         'last_name',
        //         'total'
        //     ]);

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
        //ELOQUENT METHOD
        $invoice = Invoice::with([
            'invoiceItems.track',
            'invoiceItems.track.album', //could delete this line, but would have a lot more queries
            'invoiceItems.track.album.artist'
        ])->find($id);



        //DB QUERYING METHOD
        // $invoice = DB::table('invoices')
        //     ->where('id', '=', $id)
        //     ->first(); //don't want array of things, just the single object

        // $invoiceItems = DB::table('invoice_items')
        //     ->where('invoice_id', '=', $id)
        //     ->join('tracks', 'invoice_items.track_id', '=', 'tracks.id')
        //     ->join('albums', 'tracks.album_id', '=', 'albums.id')
        //     ->join('artists', 'albums.artist_id', '=', 'artists.id')
        //     ->get([
        //         'invoice_items.unit_price',
        //         'tracks.name AS track',
        //         'albums.title AS album',
        //         'artists.name AS artist'
        //     ]);

        // if (Gate::denies('view-invoice', $invoice)) {
        //     abort(403);
        // }
        //same as:
        // if (!Gate::allows('view-invoice', $invoice)) {
        //     abort(403);
        // }
        //same as:
        // if (Auth::user()->cannot('view-invoice', $invoice)) {
        //     abort(403);
        // }
        // same as:
        // if (!Auth::user()->can('view-invoice', $invoice)) {
        //     abort(403);
        // }
        //same as:
        // $this->authorize('view-invoice', $invoice); //auto-calls abort

        //Via Invoice Policy
        $this->authorize('view', $invoice); //look for method view on invoice policy (passing in invoice object, so looks for invoice policy)
        // if (Gate::denies('view', $invoice)) { //uses gate and policy
        //     abort(403);
        // }

        return view('invoice.show', [
            'invoice' => $invoice,
            //'invoiceItems' => $invoiceItems
        ]);
    }
}
