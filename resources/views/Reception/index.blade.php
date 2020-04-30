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
            font-size: larger;
            color: white;
        }
        #btnSave:hover{
            background-color: rgb(18, 99, 73);
            border-radius: 7px;
            color: white;
            font-style: bold;
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
                            <input type="text" readonly class="form-control" name="phone" id="phone">
                        </td>
                        <td>Gender</td>
                        <td>
                            <input type="text" readonly class="form-control" name="gender" id="gender">
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
                        <td>TestShortName</td>
                        <td>
                            <input type="text" class="form-control" name="testCode" id="testCode">
                        </td>
                        <td></td>
                        <td>
                            <input type="submit" class="btn btn-success" value="Add">
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
                    <th>SlNo</th>
                    <th>TestCode</th>
                    <th>TestName</th>
                    <th>Cost</th>
                    <th>Action</th>

                    <tr>
                        <td>01</td>
                        <td>1002</td>
                        <td>CBC</td>
                        <td>230</td>
                        <td>
                            <input type="submit" class="btn btn-danger" value="X">
                        </td>
                    </tr>

                    <tr>
                        <td>01</td>
                        <td>1002</td>
                        <td>CBC</td>
                        <td>230</td>
                        <td>
                            <input type="submit" class="btn btn-danger" value="X">
                        </td>
                    </tr>

                    <tr>
                        <td>01</td>
                        <td>1002</td>
                        <td>CBC</td>
                        <td>230</td>
                        <td>
                            <input type="submit" class="btn btn-danger" value="X">
                        </td>
                    </tr>
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
                            <th><center>S.Name</center></th>
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
                        <input type="number" class="form-control" name="totalCost" id="totalCost">
                    </td>
                </tr>


                <tr>
                    <td>Discount</td>
                    <td>
                        <input type="number" class="form-control" name="totalCost" id="totalCost">
                    </td>
                </tr>

                <tr>
                    <td>NetAmount</td>
                    <td>
                        <input type="number" class="form-control" name="totalCost" id="totalCost">
                    </td>
                </tr>

                <tr>
                    <td>Paid Amount</td>
                    <td>
                        <input type="number" class="form-control" name="totalCost" id="totalCost">
                    </td>
                </tr>

                <tr>
                    <td>Due Amount</td>
                    <td>
                        <input type="number" class="form-control" name="totalCost" id="totalCost">
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


@endsection