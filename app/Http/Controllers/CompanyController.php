<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /* 
    * It redirects to the company page and displays all the company information
    * It also updates the company information into the database if the 
    * validation for each input field is successfully valid
    */
    public function index()
    {
        if (!in_array('updateCompany', $this->get_user_permission())) {
            redirect('/home');
        }



        $currency_symbols = $this->currency();
        $company_data = Company::find(1);
        return view('company.index')->with('currency_symbols', $currency_symbols)->with('company_data', $company_data);
    }



    public function update()
    {

        $this->validate(
            request(),
            [
                'company_name' => 'required',
                'service_charge_value' => 'required|integer|min:0|max:100',
                'vat_charge_value' => 'required|integer|min:0|max:100',
                'address' => 'required',
                'message' => 'required',
            ]
        );
        $data = request()->all();
        // true case
        $company = Company::find(1);
        $company->company_name = $data['company_name'];
        $company->service_charge_value = $data['service_charge_value'];
        $company->vat_charge_value = $data['vat_charge_value'];
        $company->address = $data['address'];
        $company->phone = $data['phone'];
        $company->country = $data['country'];
        $company->message = $data['message'];
        $company->currency = $data['currency'];
        $save = $company->save();
        if ($save) {
            session()->flash('success', 'Company info successfuly updated.');
            return  redirect()->back();
        } else {
            session()->flash('errors', 'Error! please refresh the page and try again.');
            return redirect()->back();
        }
    }
}
