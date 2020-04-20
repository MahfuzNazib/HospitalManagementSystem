@extends('Layouts.ReceptionApp');
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
        <div class="card-header py-3">  
        <center class="text-primary font-weight-bold ">
            Patient Registration
        </center>
    </div>


    <div class="card-body">
        <div>
            <div class="row">
                <div class="col-sm-8 bg card">
                    <table width="100%">
                    <tr>
                        <td><br>Patient ID</td>
                        <td>
                        <br>
                            <input type="text" name="pId" id="pId" class="form-control">
                            <br>
                        </td>
                    </tr>

                    <tr>
                        <td>Patient Name</td>
                        <td>
                            <input type="text" name="pName" class="form-control">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>Patient Contact</td>
                        <td>
                            <input type="text" name="pContact" class="form-control">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>Patient Gender</td>
                        <td>
                            <select class="form-control" name="pGender">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>Patient Age</td>
                        <td>
                            <input type="number" name="pAge" class="form-control">
                            <br>
                        </td>
                    </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection