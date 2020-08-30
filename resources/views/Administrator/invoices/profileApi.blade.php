<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<style>
    /*td {*/
    /*padding: .5em 0 .5em 0;*/
    /*}*/
    .due {
        display: flex !important;
        display: -webkit-flex !important;
    }

    h4 {
        display: inline !important;
    }

    /*
	 CSS-Tricks Example
	 by Chris Coyier
	 http://css-tricks.com
*/

    * {
        margin: 0;
        padding: 0;
    }

    #page-wrap {
        width: 800px;
        margin: 0 auto;
    }

    .textarea {
        border: 0;
        font: 14px Georgia, Serif;
        overflow: hidden;
        resize: none;
    }

    table {
        border-collapse: collapse;
    }

    table td, table th {

        padding: 5px;
    }

    #header {
        height: 15px;
        width: 100%;
        margin: 20px 0;
        background: #222;
        text-align: center;
        color: white;
        font: bold 15px Helvetica, Sans-Serif;
        text-decoration: uppercase;
        letter-spacing: 20px;
        padding: 8px 0px;
    }

    #address {
        width: 250px;
        height: 150px;
        float: left;
    }

    #customer {
        overflow: hidden;
    }

    #logo {
        text-align: right;
        float: right;
        position: relative;
        margin-top: 25px;
        border: 1px solid #fff;
        max-width: 540px;
        max-height: 100px;
        overflow: hidden;
    }

    #logo:hover, #logo.edit {
        border: 1px solid #000;
        margin-top: 0px;
        max-height: 125px;
    }

    #logoctr {
        display: none;
    }

    #logo:hover #logoctr, #logo.edit #logoctr {
        display: block;
        text-align: right;
        line-height: 25px;
        background: #eee;
        padding: 0 5px;
    }

    #logohelp {
        text-align: left;
        display: none;
        font-style: italic;
        padding: 10px 5px;
    }

    #logohelp input {
        margin-bottom: 5px;
    }

    .edit #logohelp {
        display: block;
    }

    .edit #save-logo, .edit #cancel-logo {
        display: inline;
    }

    .edit #image, #save-logo, #cancel-logo, .edit #change-logo, .edit #delete-logo {
        display: none;
    }

    #customer-title {
        font-size: 20px;
        font-weight: bold;
        float: left;
    }

    #meta {
        margin-top: 1px;
        width: 300px;
        float: right;
    }

    #meta td {
        text-align: right;
    }

    #meta td.meta-head {
        text-align: left;
        background: #eee;
    }

    #meta td .textarea {
        width: 100%;
        height: 20px;
        text-align: right;
    }

    #items {
        clear: both;
        width: 100%;
        margin: 0 0 0 0;
    }

    #items .textarea {
        width: 80px;
        height: 50px;
    }

    #items tr.item-row td {
        border: 0;
        vertical-align: top;
    }

    #items td.description {
        width: 300px;
    }

    #items td.item-name {
        width: 175px;
    }

    #items td.description .textarea, #items td.item-name .textarea {
        width: 100%;
    }

    /*#items td.total-line {*/
        /*border-right: 0;*/
        /*text-align: right;*/

    /*}*/

    /*#items td.total-value {*/
        /*border-left: 0;*/
    /*}*/

    #items td.total-value .textarea {
        height: 20px;
        background: none;
    }


    #items td.blank {
        border: 0;
    }


    #first {
        clear: both;
        width: 100%;
        margin: 30px 0 0 0;
    }

    #first th {
        background: #eee;
    }

    #first .textarea {

    }

    #first tr.item-row td {
        border: 0;
    }

    #first td.description {
        width: 300px;
    }

    #first td.item-name {
        width: 680px;
        top: 55px;
    }

    #first td.price {
        width: 300px;
        font-size: 23px;
        font-weight: bold;
    }
    #first td.qty {
        width: 240px;
        padding-top: 270px;
        font-size: 25px;
    }

    #first td.description .textarea, #items td.item-name .textarea {
        width: 100%;
    }

    #first td.total-line {
        border-right: 0;
        text-align: right;
    }

    #first td.total-value {
        border-left: 0;
        padding: 10px;
    }

    #first td.total-value .textarea {

        background: none;
    }

    #first td.balance {
        background: #eee;
    }

    #first td.blank {
        border: 0;
    }

    #terms {
        text-align: center;
        margin: 20px 0 0 0;
    }

    #terms
    {
        text-transform: uppercase;
        font: 13px Helvetica, Sans-Serif;
        letter-spacing: 10px;
        border-bottom: 1px solid black;
        padding: 0 0 8px 0;
        margin: 0 0 8px 0;
    }

    #terms .textarea {
        width: 100%;
        text-align: center;
    }

    .textarea:hover, .textarea:focus, #items td.total-value .textarea:hover, #items td.total-value .textarea:focus, .delete:hover {
        background-color: #EEFF88;
    }

    .delete-wpr {
        position: relative;
    }

    .delete {
        display: block;
        color: #000;
        text-decoration: none;
        position: absolute;
        background: #EEEEEE;
        font-weight: bold;
        padding: 0px 3px;
        border: 1px solid;
        top: -6px;
        left: -22px;
        font-family: Verdana;
        font-size: 12px;
    }
</style>

@if(!empty($invoice))

    <div class="invoice">

        <div id="page-wrap">


            <div style="clear:both"></div>

            <div id="customer">


                <table id="first">
                    <tr class="item-row">
                        <td class="item-name">

                            <span style="font-weight: 500;
    font-size: 40px;">INVOICE</span> <br>
                            <span style="font-size: 28px;">
                                 @if(!empty($invoice->customer))<p>
                                            {{ $invoice->customer->full_name }}
                                @endif
                            </span>

                        </td>

                        <td class="price">
                                <strong>  <img src="{{ asset('public/NewFront/images/logo.png') }}"
                                               class="img-responsive" style="width: 40%;" alt=""/></strong>

                                <div class="col-xg-12">
                               <b>
                                   Invoice Date <br> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-M-Y') }}
                               </b>
                                    </div>
                                   <div class="col-xs-12" style=""><b> Invoice Number <br> {{ $invoice->invoice_code }}</b>
                                   </div>
                                   <div class="col-xs-12"
                                        style=""><b> Account Number <br> {{ $invoice->customer->eithar_id ?  $invoice->customer->eithar_id :'' }}</b>
                                   </div>
                            </td>
                        <td class="qty">  <b> Eithar Home Care<br>
                            Company <br>
                            King Salman road <br>
                            RIYADH RIYADH <br>
                            RIYADH RIYADH <br>
                            5136-13525 <br>
                            SAUDI ARABIA <br>
                            Tel: +966118103234 <br>
                            VAT NO# <br>
                            310192853900003</b>
                            </td>
                    </tr>


                </table>


                <table id="items" >

                    <tr>
                        <th style="border-bottom: 1px solid #000;  width: 1.5em; height: 2.5em;">Description</th>
                        <th style="border-bottom: 1px solid #000;  width: 1.5em; height: 2.5em;">Quantity</th>
                        <th style="border-bottom: 1px solid #000;  width: 1.5em; height: 2.5em;">Unit Price</th>
                        <th style="border-bottom: 1px solid #000;  width: 1.5em; height: 2.5em;">Discount</th>
                        <th style="border-bottom: 1px solid #000;  width: 1.5em; height: 2.5em;">Tax</th>
                        <th style="border-bottom: 1px solid #000;  width: 1.5em; height: 2.5em;">Amount SAR</th>
                    </tr>
                    @foreach($invoice->items as $item)
                    <tr class="item-row">


                        <td class="item-name" style="border-bottom: 1px solid #000;  width: 1.5em; height: 2.5em;">
                            <div class="delete-wpr">
                                <div class="textarea">{{$item->item_desc_appear_in_invoice}}</div>
                            </div>
                        </td>
                        <td class="description" style="border-bottom: 1px solid #000;  width: 1.5em; height: 2.5em;">
                            <div class="textarea">{{$item->quantity}}
                            </div>
                        </td>
                        <td style="border-bottom: 1px solid #000;  width: 1.5em; height: 2.5em;">
                            <div class="textarea cost">{{$item->price}}</div>
                        </td>
                        <td style="border-bottom: 1px solid #000;  width: 1.5em; height: 2.5em;">
                            <div class="textarea qty" >{{$item->discount_percent ? $item->discount_percent.'%' : '0.00%'  }}</div>
                        </td>
                        <td style="border-bottom: 1px solid #000;  width: 1.5em; height: 2.5em;"><span class="price">{{$item->tax_percent ? $item->tax_percent.'%': 'Tax Exempt'}}</span></td>
                        <td style="border-bottom: 1px solid #000;  width: 1.5em; height: 2.5em;"><span class="price">{{$item->final_amount}}</span></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" class="blank"></td>
                        <td colspan="1" class="blank"></td>
                        <td colspan="2" class="total-line" style="border-bottom: 1px solid #000;  width: 1.5em; height: 2.5em; padding-right: 10px;" >Subtotal</td>
                        <td class="total-value" style="border-bottom: 1px solid #000;  width: 1.5em; height: 2.5em; padding-right: 10px;">
                            <div id="total">{{$invoice->items->sum('discount')}}</div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="blank"></td>
                        <td colspan="1" class="blank"></td>
                        <td colspan="2" class="total-line" style="font-weight: bold" >AMOUNT DUE SAR</td>
                        <td class="total-value" style="">
                            <div id="total" style="font-weight: bold;">{{$invoice->amount_final}}</div>
                        </td>
                    </tr>

                </table>


            </div>

            <hr/>
            <div class="row invoice-logo"><b><h4> Duo Date:
                        {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}</h4></b></div>
            @if($invoice->is_paid==1)
                <div class="row invoice-logo"><h5>Payment
                        Method: {{ config('constants.payment_methods.'.$invoice->payment_method) }}</h5></div>
                @if($invoice->payment_method !=1)
                    <br/>
                    <div class="row invoice-logo"><h5> Payment Transaction:
                            {{ $invoice->payment_transaction_number }}</h5></div>
                @endif
            @endif

            <div class="row invoice-logo"><h5> VAT Number:
                    310192853900003 </h5></div>
            <div class="row invoice-logo"><h5>   Riyad bank :
                    #IBAN SA3220000002362295769941 </h5></div>
            <div class="row invoice-logo"><h5>     Arab National Bank :
                    #IBAN SA8930400108095324960025 </h5></div>
            <div class="row invoice-logo"><h5> Thanks</h5></div>
            <div class="row invoice-logo"><h5> Eithar Home Care Company</h5></div>
        </div>




                 <hr/>

        Company Registration No: 1010950408. Registered Office: King Salman road, Riyadh, Riyadh, 6761-12458, Saudi
        Arabia
        </div>

        @endif