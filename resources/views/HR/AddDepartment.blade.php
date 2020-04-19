@extends('Layouts.App')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
        <div class="card-header py-3">  
        <center class="text-primary font-weight-bold ">
            Add New Hospital Department
        </center>
    </div>


    <div class="card-body">
        <div>
            <div class="row">
                <div class="col-sm-6 bg card">
                    <form method="POST">
                        {{ csrf_field() }}
                        <table width="100%">
                            <tr>
                                <td>Dept. Code</td>
                                <td>
                                    <input type="text" class="form-control" name="deptCode">
                                </td>
                            </tr>

                            <tr>
                                <td>Dept. Name</td>
                                <td>
                                    <input type="text" class="form-control" name="deptName">
                                </td>
                            </tr>

                            <tr>
                                <td>Date</td>
                                <td>
                                    <input type="date" class="form-control" name="deptAddingDate">
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <a href="{{ route('HR.insertDept') }}">
                                        <input type="submit" class="btn btn-primary" value="Add Department">
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <!-- Existing Hospital Department -->
                <div class="col-sm-6">
                    <div class="container bg card">
                        <table width="100%" class="table">
                            <tr>
                                <th>DeptID</th>
                                <th>DeptName</th>
                                <th>Action</th>
                            </tr>

                            @foreach($dept as $dept)
                                <tr>
                                    <td>{{ $dept['id'] }}</td>
                                    <td>{{ $dept['deptName'] }}</td>
                                    <td>
                                        <a href="#">
                                            <i class="fas fa-user btn btn-success"></i>
                                        </a>|
                                        <a href="#">
                                            <i class="far fa-trash-alt btn btn-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection