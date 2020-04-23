@extends('Layouts.ReceptionApp')
@section('content') 

    <!-- Body Main Part Start Here -->
    <div class="row">
        <div class="col-sm-7">
            <div class="container bg card">
                Patient Information
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
                        <td>TestCode</td>
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
                <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#testList">
                    View Test List
                </button>

                <div id="testList" class="collapse">
                    <table class=" table-hover">
                        <th>TestCode</th>
                        <th>TestName</th>
                        <th>Cost</th>

                        <tr>
                            <td>1001</td>
                            <td>CBC</td>
                            <td>300</td>
                        </tr>

                        <tr>
                            <td>1001</td>
                            <td>CBC</td>
                            <td>300</td>
                        </tr>

                        <tr>
                            <td>1001</td>
                            <td>CBC</td>
                            <td>300</td>
                        </tr>
                        <tr>
                            <td>1001</td>
                            <td>CBC</td>
                            <td>300</td>
                        </tr>

                    </table>
                </div>
            </div>

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
                    <td colspan="1">
                        <center>
                        <input type="submit" class="btn btn-info" value="SAVE">
                        </center>
                    </td>
                </tr>
            </table>
        </div>
    </div>


@endsection