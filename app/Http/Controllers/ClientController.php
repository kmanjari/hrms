<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;


/**
 * Class ClientController
 * @package App\Http\Controllers
 */
class ClientController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addClient()
    {
        return view('hrms.clients.add-client');
    }

    /**
     * @param $code
     *
     * @return string
     */
    public function validateCode($code)
    {
        $client = Client::where('code', $code)->first();
        if($client)
        {
            return json_encode(['status' => false]);
        }
        return json_encode(['status' => true]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveClient(Request $request)
    {
        $client = new Client();
        $client->fill(array_except($request->all(),'_token'));
        $client->save();
        \Session::flash('flash_message', 'Client saved successfully');
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listClients()
    {
        $clients = Client::paginate(15);
        return view('hrms.clients.list', compact('clients'));
    }

    /**
     * @param $clientId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEdit($clientId)
    {
        $client = Client::where('id', $clientId)->first();
        return view('hrms.clients.edit', compact('client'));
    }

    /**
     * @param Request $request
     * @param $clientId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveClientEdit(Request $request, $clientId)
    {
        try {
            $client = Client::where('id', $clientId)->first();
            $client->fill(array_except($request->all(), '_token'));
            $client->save();

            \Session::flash('flash_message', 'Client saved successfully');
        }
        catch(\Exception $e)
        {
            \Session::flash('flash_message', $e->getMessage());
        }
        return redirect()->back();

    }

    public function doDelete($id)
    {
        $client = Client::where('id',$id);
        $client->delete();

        \Session::flash('flash_message', 'Client successfully Deleted!');
        return redirect('list-client');
    }
}
