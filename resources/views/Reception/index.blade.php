@extends('Layouts.ReceptionApp')
@section('content') 

    <!-- Test List Table Style -->
    <style>
        #tblHeader{
            height: 30px;
            width: 100%;
            padding: 0;
            margin: 0;
            background-color: gray;
            color: white;
        }
        #tHead{
            font-family: Tahoma;
            width:100%;
            cellspacing:0px;
            cellpadding:0px;
        }
        #testListData{
            height: 130px;
            width:100%;
            overflow: auto;
            overflow-x: hidden;
            text-align: center;
            color: gray;
        }
        #tblData{
            text-align: center;
            font-family: 'Lucida Bright';
            width:100%;
            cellspacing:0px;
            cellpadding:0px;
        }

        /* Save Button Style */
        #btnSave{
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
        #btnSave:hover{
            background-color: rgb(18, 99, 73);
            border-radius: 7px;
            color: white;
            font-size: larger;
        }
    </style>
    <!-- Body Main Part Start Here -->
    <div class="row">
        <div class="col-sm-7">
            <div class="container bg card">
                <center class="text-primary font-weight-bold">Patient Information</center>
                <hr>
                <table>
                    <tr>
                        <td>P_ID</td>
                        <td>
                            <input type="text" class="form-control" name="patientId" id="patientId">
                        </td>


                        <td>P_Name</td>
                        <td>
                            <input type="text" readonly class="form-control" name="patientName" id="patientName">
                        </td>

                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td>
                            <input type="text" readonly class="form-control" name="phone" id="patientPhone">
                        </td>
                        <td>Gender</td>
                        <td>
                            <input type="text" readonly class="form-control" name="gender" id="patientGender">
                        </td>
                    </tr>
                    <tr>
                        <td>DrCode</td>
                        <td>
                            <input type="text" readonly class="form-control" name="drCode" id="drCode">
                        </td>
                        <td>DrName</td>
                        <td>
                            <input type="text" readonly class="form-control" name="drName" id="drName">
                        </td>
                    </tr>
                </table>
                <br>
                <hr>

                <table>
                    <tr>
                        <td>TestCode</td>
                        <td>
                            <input type="text" class="form-control" name="testCode" id="testCode">
                        </td>
                        <td></td>
                        <!-- Adding Button -->
                        <td>
                            <button class="btn btn-primary" id="btnAddTest">Add Test</button>
                        </td>
                    </tr>

                    <tr>
                        <td>TestName</td>
                        <td>
                            <input type="text" readonly class="form-control" name="testName" id="testName">
                        </td>

                        <td>Cost</td>
                        <td>
                            <input type="text" readonly class="form-control" name="testCost" id="testCost">
                        </td>
                    </tr>
                </table>
                <!-- Added Test List -->

                <table width="100%">
                    <thead id="tblHeader">
                        <th>SlNo</th>
                        <th>TestCode</th>
                        <th>TestName</th>
                        <th>Cost</th>
                        <th>Action</th>
                    </thead>
                    
                    <tbody id="testList">

                    </tbody>
                </table>
            </div>
        </div>
        

        <div class="col-sm-5">
            <div class="container bg card">
                <br>
                    <center class="text-primary font-weight-bold">Hospital Test List</center>
                    <hr>
                    <div id="tblHeader">
                        <table  class=" table-hover" id="tHead">
                            <th><center>TestCode</center></th>
                            <th><center>TestName</center></th>
                            <th><center>Cost</center></th>
                        </table>
                    </div>

                    <div id="testListData">
                    <table id="tblData">
                        @foreach($testList as $test)
                            <tr>
                                <td>
                                    <center>{{ $test['testShortName'] }}</center>
                                </td>

                                <td>
                                    <center>{{ $test['testName'] }}</center>
                                </td>

                                <td>
                                    <center>{{ $test['testCost'] }}</center>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    </div>
            </div>

            <div class="container bg card">
            <center class="text-primary font-weight-bold">Billing Information</center>
            <table>
                <tr>
                    <td>Total Cost</td>
                    <td>
                        <input type="number" readonly class="form-control" name="totalCost" id="totalCost" value=0>
                    </td>
                </tr>


                <tr>
                    <td>Discount(TK)</td>
                    <td>
                        <input type="number" class="form-control" name="discount" id="discount" value=0>
                    </td>
                </tr>

                <tr>
                    <td>NetAmount</td>
                    <td>
                        <input type="number" readonly class="form-control" name="netAmount" id="netAmount">
                    </td>
                </tr>

                <tr>
                    <td>Paid Amount</td>
                    <td>
                        <input type="number"  class="form-control" name="paidAmount" id="paidAmount">
                    </td>
                </tr>

                <tr>
                    <td>Due Amount</td>
                    <td>
                        <input type="number" readonly class="form-control" name="dueAmount" id="dueAmount">
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <button id="btnSave">Save</button>
                    </td>
                </tr>
            </table>
            </div>
        </div>
    </div>


    <!-- JS Code/Ajax Code -->

    <script>
        $(document).ready(function(){
            //Patient Field Variable Declaration
            var noData = '';
            var patientName = '';
            var patientPhone = '';
            var patientGender = '';
            var drName = '';
            //Test Field Variable Declaration
            var td = '';
            var msg = 'No Test Record Found';
            var testName = '';
            var testCost = '';

            //TestList Variable Declaration
            var testDataList = '';

            // Billing Calculation Variables
            var initialTotalCost='';
            var totalCost = '';
            var discount = '';
            var netAmount = '';
            var paidAmount = '';
            var dueAmount = ''; 

            //Get Patient Information from PatientId
            $(document).on('change', '#patientId', function(){
                var pId = $(this).val();
                console.log(pId);
                $.ajax({
                    url : "{{ route('Reception.patientData') }}",
                    method: 'GET',
                    data: {data:noData,pId},
                    success:function(data){
                        console.log('Data Returned Success');
                        // console.log(data);

                        //Refresh all Variable Data
                        patientName = '';
                        patientPhone = '';
                        patientGender = '';
                        drName = '';
                        for(var i=0; i<data.length; i++){
                            if(data[i].name == undefined){
                                alert('No Record Found');
                                break;
                            }
                            else{
                                patientName += data[i].name;
                                patientPhone += data[i].contact;
                                patientGender += data[i].gender;
                            }
                        }

                        $('#patientName').val(patientName);
                        $('#patientGender').val(patientGender);
                        $('#patientPhone').val(patientPhone);
                    }
                });
            });

            //Test Name by TestCode
            
            $(document).on('keyup','#testCode', function(){
                if(patientName == ''){
                    alert('Please Entere a Valid Patient ID');
                }
                else{
                    var testCode = $(this).val();
                    console.log(testCode);

                    $.ajax({
                        url: "{{ route('Reception.testInfo') }}",
                        method: 'GET',
                        data: {data:noData,testCode},
                        success:function(data){
                            console.log('Test AJAX Return');
                            console.log(data);

                            td = '';
                            testName = '';
                            testCost = '';
                            for(var i=0; i<data.length; i++){
                                if(data[i].testName == undefined){
                                    td += '<tr>'
                                    td += '<td></td>'
                                    td += '<td>'+msg+'</td>'
                                    td += '<td></td>'
                                    td += '</tr>'
                                    break;
                                }
                                else{
                                    td += '<tr>'
                                    td += '<td>'+data[i].testShortName+'</td>'
                                    td += '<td>'+data[i].testName+'</td>'
                                    td += '<td>'+data[i].testCost+'</td>'
                                    td += '</tr>'

                                    testName += data[i].testName;
                                    testCost += data[i].testCost;
                                }
                                
                            }

                            $('#tblData').html(td);
                            if(testCode != ''){
                                $('#testName').val(testName);
                                $('#testCost').val(testCost);
                            }
                            else{
                                $('#testName').val('');
                                $('#testCost').val('');
                            }
                        }
                    });
                }     
            });  
            
            //Add TempTest List 

            $(document).on('click', '#btnAddTest', function(){
                var btnAddTest = $(this).val();

                var testCode = $('#testCode').val();
                var testName = $('#testName').val();
                var testCost = $('#testCost').val();


                $.ajax({
                    url: "{{ route('Reception.tempTestList') }}",
                    method: 'GET',
                    data:{data: noData,testCode,testName,testCost},
                    success:function(data){
                        console.log(data);
                        testDataList='';
                        for(var i=0; i<data.length;i++){
                            testDataList += '<tr>'
                            testDataList += '<td>'+data[i].id+'</td>'
                            testDataList += '<td>'+data[i].testCode+'</td>'
                            testDataList += '<td>'+data[i].testName+'</td>'
                            testDataList += '<td>'+data[i].testCost+'</td>'
                            testDataList += '<td> <input type="button" class="btn btn-danger" value="'+data[i].id+'"X </td>'
                            testDataList += '</tr>'
                        }
                        $('#testList').html(testDataList);

                        //Billing Calculation 
                         initialTotalCost = $('#totalCost').val();
                         totalCost = parseInt(initialTotalCost) + parseInt(testCost) ;
                         discount = $('#discount').val();
                        $('#totalCost').val(totalCost);
                         netAmount = totalCost - parseInt(discount);
                        $('#netAmount').val(netAmount); 
                    }
                });

                
            });

            $(document).on('keyup','#discount', function(){
                discount = $('#discount').val();
                $('#totalCost').val(totalCost);
                netAmount = totalCost - parseInt(discount);
                $('#netAmount').val(netAmount); 
            });

        });
    </script>

@endsection