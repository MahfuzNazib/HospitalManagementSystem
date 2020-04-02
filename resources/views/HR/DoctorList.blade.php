@extends('Layouts.App')
@section('content') 

    <center>
        <h3 class="m-0 font-weight-bold text-primary">Doctor List</h3> 
    </center>


    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">
    <!-- <h6 class="m-0 font-weight-bold text-primary">Doctor List</!-->  

    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-2 large" placeholder="Doctor Name or ID" aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
        </form>
  </div>


  <!-- @if(session('msg'))
            <div class="alert alert-success">
              {{session('msg')}}
            </div>
      @endif -->
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Doctor ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Department</th>
            <th>Specialist</th>
            <th>Action</th>
          </tr>
        </thead>
        <!-- <tfoot>
          <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Age</th>
            <th>Start date</th>
            <th>Salary</th>
          </tr>
        </tfoot> -->
        
          <tbody>
          @foreach($doctors as $doctor)
            <tr>
              <td>{{$doctor['DoctorId']}}</td>
              <td>{{$doctor['Name']}}</td>
              <td>{{$doctor['Phone']}}</td>
              <td>{{$doctor['Department']}}</td>
              <td>{{$doctor['Specialist']}}</td>
              <td>
                  <a href="{{route('HR.doctorProfile', $doctor['DoctorId'])}}">
                      <i class="fas fa-user btn btn-success"></i>
                  </a>
                  <a href="#">
                      <i class="far fa-trash-alt btn btn-danger"></i>
                  </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      {{$doctors->links()}}
    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
@endsection