@extends('Layouts.App')
@section('content') 

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add New Doctor</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div>

          @if(session('msg'))
            <div class="alert alert-success">
              {{session('msg')}}
            </div>
          @endif
          <!--Error List Show-->
          @if($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif



      <!--Body Main Part-->

      <div class="row">
        <div class="col-sm-8">
          <div class="container bg card">
            <form method="POST">
              {{csrf_field()}}
              <table width="100%">
                <tr>
                  <td colspan="2">
                    <center>
                      Personal Information
                    </center>
                  </td>
                </tr>
                <tr>
                  <td>Doctor ID</td>
                  <td>
                    <input type="text"  readonly class="form-control" value="D-123455" name="DID">
                  </td>
                </tr>

                <tr>
                  <td>Full Name</td>
                  <td>
                    <input type="text" class="form-control" value="" name="name">
                  </td>
                </tr>

                <tr>
                  <td>DOB</td>
                  <td>
                    <input type="date" class="form-control" value="" name="dob">
                  </td>
                </tr>

                <tr>
                  <td>Gender</td>
                  <td>
                    <select class="form-control" name="gender">
                      <option></option>
                      <option>Male</option>
                      <option>Female</option>
                    </select>
                  </td>
                </tr>

                <tr>
                  <td>Phone</td>
                  <td>
                    <input type="number" class="form-control" value="" name="phone">
                  </td>
                </tr>

                <tr>
                  <td>Emergency</td>
                  <td>
                    <input type="number" class="form-control" value="" name="emergency">
                  </td>
                </tr>

                <tr>
                  <td>Email</td>
                  <td>
                    <input type="email" class="form-control" value="" name="email">
                  </td>
                </tr>

                <tr>
                  <td>Address</td>
                  <td>
                    <input type="text" class="form-control" value="" name="address">
                  </td>
                </tr>

                <tr>
                  <td colspan="2"><hr></td>
                </tr>
                <tr>
                  <td colspan="2">
                    <center>
                      Institutional Information
                    </center>
                  </td>
                </tr>
                <tr>
                  <td>Department</td>
                  <td>
                    <select class="form-control" name="department">
                      <option></option>
                      <option>Dental</option>
                      <option>Neourology</option>
                      <option>Heart</option>
                      <option>Cardiology</option>
                      <option>Ear,Nose & Tharot(ENT)</option>
                    </select>
                  </td>
                </tr>


                <tr>
                  <td>Specialist</td>
                  <td>
                    <select class="form-control" name="specialist">
                      <option></option>
                      <option>Dentist</option>
                      <option>Neourologist</option>
                      <option>Cardiologiest</option>
                      <option>Cardiologiest</option>
                      <option>ENTeist</option>
                    </select>
                  </td>
                </tr>

                <tr>
                  <td>Visiting Hour</td>
                  <td>
                    <input type="time" class="timec" name="time"> To
                    <input type="time" class="timec"> 
                  </td> 
                </tr>

                <tr>
                  <td>Visiting Fee</td>
                  <td>
                    <input type="number" class="form-control" name="visitingFee" value="">
                  </td>
                </tr>

                <tr>
                  <td>Comission (%)</td>
                  <td>
                    <input type="number" class="form-control" name="comission" value="">
                  </td>
                </tr>

                <tr>
                  <td>Closing Day</td>
                  <td>
                  <select class="form-control" name="closingDay">
                      <option>None</option>
                      <option>Sat</option>
                      <option>Sun</option>
                      <option>Mon</option>
                      <option>Tue</option>
                      <option>Wed</option>
                      <option>Thus</option>
                      <option>Fri</option>
                
                    </select>
                  </td>
                </tr>

                <tr>
                  <td colspan="2">
                    <a href="{{route('HR.insertDoctor')}}">
                    <center>
                      <input type="submit" class="btn btn-success" value="Registered">
                    </center>
                    </a>
                  </td>
                </tr>

              </table>
            </form>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="container bg card">
            Set a profile Picture
            <br>
            <img src="" height="150px" width="150px"> <br>
            
            <input type="file" class="btn btn-info" value="Select a Picture">
          </div>
        </div>
      </div>

      <!--End Of Body Main Part-->
@endsection