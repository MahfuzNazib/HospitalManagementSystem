@extends('Layouts.ReceptionApp')
@section('content')
    <style>
        /* Delivery Button Style */
        #btnDelivery{
            width: 100%;
            height: 45px;
            border-radius: 5px;
            border:none;
            padding: 0;
            background-color: rgb(24, 150, 110);
            font-family: 'Lucida Bright';
            font-size: large;
            color: white;
        }
        #btnDelivery:hover{
            background-color: rgb(18, 99, 73);
            border-radius: 7px;
            color: white;
            font-size: larger;
        }

        /* Refresh Button */
        #refresh{
            width: 100%;
            height: 35px;
            border-radius: 5px;
            border:none;
            padding: 0;
            background-color: rgb(6,104,143);
            font-family: 'Lucida Bright';
            font-size: large;
            color: white;
        }
        #refresh:hover{
            background-color: rgb(5,79,109);
            border-radius: 7px;
            color: white;
            font-size: larger;
        }
    </style>

    <div class="container-fluid">
        <div class="card shadow mb-4">
        <div class="card-header py-3">  
        <center class="text-primary font-weight-bold ">
            Report Delivery Section
        </center>
    </div>


    <div class="card-body">
        <div>
            <div class="row">
                <div class="col-sm-7 ">
                    <table border="0">
                        <tr>
                            <td>InvoiceNo </td>
                            <td>
                                <input type="text" class="form-control" name="invoiceNo" id="invoiceNo" placeholder="Enter Last 5 Digits">
                            </td>
                            <td>
                                Invoice Status
                            </td>
                            <td>
                                <h5><span id='status'>  </span></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>Patient Name </td>
                            <td>
                                <input type="text" readonly class="form-control" name="patientName" id="patientName">
                            </td>
                            <td>
                                Delivery Status:
                            </td>
                            <td>
                                <h5><span id='reportDelivery'> </span></h5>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>Patient Phone </td>
                            <td>
                                <input type="text" readonly class="form-control" name="patientPhone" id="patientPhone">
                            </td>
                            
                            <!-- Page Refresh Button -->
                            <td colspan="2">
                                <input type="button"  value="Refresh" id="refresh">
                            </td>
                        </tr>
                    </table>

                    <div>
                        <br>
                        <!-- Test List Records  -->
                        <table width="100%" class="table">
                            <thead>
                                <th>TestCode</th>
                                <th>TestName</th>
                                <th>TestCost</th>
                            </thead>

                            <tbody id="testRecords">

                            </tbody>
                        </table>
                    </div>
                    
                </div>

                <!-- Billing Information -->
                <div class="col-sm-5">
                    <table>
                        <tr>
                            <td>InvoiceNo </td>
                            <td>
                                <input type="text" readonly class="form-control" name="invoiceNo" id="invoiceNo2">
                            </td>
                        </tr>

                        <tr>
                            <td>Invoice Date </td>
                            <td>
                                <input type="text" readonly class="form-control" name="invoiceNo" id="invoiceDate">
                            </td>
                        </tr>


                        <tr>
                            <td>Total Cost</td>
                            <td>
                                <input type="text" readonly class="form-control" name="totalCost" id="totalCost">
                            </td>
                        </tr>


                        <tr>
                            <td>Discount(TK)</td>
                            <td>
                                <input type="text" readonly class="form-control" name="discount" id="discount">
                            </td>
                        </tr>

                        <tr>
                            <td>NetAmount</td>
                            <td>
                                <input type="text" readonly class="form-control" name="netAmount" id="netAmount">
                            </td>
                        </tr>

                        <tr>
                            <td>Paid Amount</td>
                            <td>
                                <input type="text" readonly class="form-control" name="paidAmount" id="paidAmount">
                            </td>
                        </tr>

                        <tr>
                            <td>New Amount</td>
                            <td>
                                <input type="number"  class="form-control" name="newAmount" id="newAmount">
                            </td>
                        </tr>

                        <tr>
                            <td>Given Amount</td>
                            <td>
                                <input type="number"  class="form-control" name="givenAmount" id="givenAmount">
                            </td>
                        </tr>

                        <tr>
                            <td>Return Amount</td>
                            <td>
                                <input type="number" readonly class="form-control" name="returnAmount" id="returnAmount">
                            </td>
                        </tr>

                        <tr>
                            <td>Due Amount</td>
                            <td>
                                <input type="text" readonly class="form-control" name="dueAmount" id="dueAmount">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="button"  id="btnDelivery" value="Report Delivery">
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- JavaScript Code Here -->

    <script>
        $(document).ready(function(){
            var noData = '';
            // OnChange Event Fire on Invoice feild
            $(document).on('change', '#invoiceNo', function(){
                var invoiceNo = $(this).val();
                if(invoiceNo == null){
                    alert('Please Enter a Valid InvoiceNo');
                }
                else{
                    $.ajax({
                        url: "{{ route('Reception.reportDeliveryInfo') }}",
                        method: 'GET',
                        data:{data:noData,invoiceNo},
                        success:function(data){
                            console.log(data);

                            for(var i=0; i<data.length; i++){
                                
                                // var patientName = data[i].patientName; 
                                // var patientPhone = data[i].patientPhone;
                                var invoiceNo = data[i].invoiceNo;

                                if(data[i].invoiceNo == undefined){
                                    alert('No Record Found');
                                    break;
                                }
                                else{
                                    var invoiceNo2 = data[i].invoiceNo;
                                    var patientName = data[i].patientName; 
                                    var patientPhone = data[i].patientPhone;
                                    var invoiceDate = data[i].invoiceDate;
                                    var totalCost = data[i].totalCost;
                                    var discount = data[i].discount;
                                    var netAmount = data[i].netAmount;
                                    var paidAmount = data[i].paidAmount;
                                    var dueAmount = data[i].dueAmount;
                                    var status = data[i].status;
                                    var reportDelivery = data[i].reportDelivery;

                                    if(data[i].status == 'Clear'){
                                        status = '<text class="badge badge-success">'+data[i].status+'</text>'
                                    }
                                    else{
                                        status = '<text class="badge badge-danger">'+data[i].status+'</text>'
                                    }

                                    if(data[i].reportDelivery == 'Not Delivered'){
                                        reportDelivery = '<text class="badge badge-warning">'+data[i].reportDelivery+'</text>'

                                    }
                                    else{
                                        reportDelivery = '<text class="badge badge-success">'+data[i].reportDelivery+'</text>'
                                    }
                                }
                            }

                            $('#patientName').val(patientName);
                            $('#patientPhone').val(patientPhone);
                            $('#invoiceDate').val(invoiceDate);
                            $('#invoiceNo2').val(invoiceNo2);
                            $('#totalCost').val(totalCost);
                            $('#discount').val(discount);
                            $('#netAmount').val(netAmount);
                            $('#paidAmount').val(paidAmount);
                            $('#dueAmount').val(dueAmount);
                            $('#status').html(status);
                            $('#reportDelivery').html(reportDelivery);
                        }
                    });
                }

            });

            //New Amount Field
            $(document).on('keyup', '#newAmount', function(){
                var newAmount = $(this).val();
                var netAmount = $('#netAmount').val();
                var paidAmount = $('#paidAmount').val();
                var dueAmount = parseInt(netAmount) - (parseInt(paidAmount) + parseInt(newAmount));
                $('#dueAmount').val(dueAmount);

                //Given Amount
                var givenAmount = $('#newAmount').val();
                $('#givenAmount').val(givenAmount);
                var returnAmount = parseInt(givenAmount) - parseInt(newAmount);
                $('#returnAmount').val(returnAmount);
            });

            //Given Amount Field
            $(document).on('keyup', '#givenAmount', function(){
                var givenAmount = $(this).val();
                var newAmount = $('#newAmount').val();
                var returnAmount = parseInt(givenAmount) - parseInt(newAmount);
                $('#returnAmount').val(returnAmount);
            });

            //Refresh Button Click
            $(document).on('click', '#refresh', function(){
                $('#patientName').val('');
                $('#patientPhone').val('');
                $('#invoiceNo').val('');
                $('#invoiceNo2').val('');
                $('#totalCost').val('');
                $('#discount').val('');
                $('#netAmount').val('');
                $('#paidAmount').val('');
                $('#dueAmount').val('');
                $('#newAmount').val('');
                $('#givenAmount').val('');
                $('#returnAmount').val('');
                $('#invoiceDate').val('');
                $('#status').html('');
                $('#reportDelivery').html('');

            });

            //Click Delivery Button 
            $(document).on('click', '#btnDelivery', function(){
                var invoiceNo = $('#invoiceNo2').val();
                if(invoiceNo == ''){
                    alert('Please Enter a Valid Invoice No');
                }
                else{
                    alert(invoiceNo);
                    var paidAmount = $('#netAmount').val();
                    var dueAmount = $('#dueAmount').val();

                    alert("p "+paidAmount+' d: '+dueAmount);
                    $.ajax({
                        url: "{{ route('Reception.updateInvoice') }}",
                        method: 'GET',
                        data:{data:noData, paidAmount,dueAmount,invoiceNo},
                        success:function(data){
                            console.log(data);
                            alert('Delivery Successfully Done!');
                        }
                    });
                }
            });
        });
    </script>

@endsection