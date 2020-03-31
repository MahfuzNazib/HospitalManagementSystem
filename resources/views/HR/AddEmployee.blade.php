@extends('Layouts.App')
@section('content') 

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add New Employee</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div>

      <!--Body Main Part-->

      <div class="row">
        <div class="col-sm-8">
          <div class="container bg card">
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
                  <td>Email</td>
                  <td>
                    <input type="email" class="form-control" value="" name="email">
                  </td>
                </tr>

                <tr>
                  <td>Designation</td>
                  <td>
                    <select class="form-control" name="gender">
                      <option></option>
                      <option>HR</option>
                      <option>Manager</option>
                      <option>Receiptionist</option>
                      <option>Nurse</option>
                      <option>Word Boy</option>
                      <option>Gatemen</option>
                    </select>
                  </td>
                </tr>

                <tr>
                  <td>Address</td>
                  <td>
                    <textarea class="form-control">
                      
                    </textarea>
                    <!-- <input type="text" class="form-control" value="" name="email"> -->
                  </td>
                </tr>

                

                <tr>
                  <td colspan="2">
                    <center>
                      <input type="submit" class="btn btn-success" value="Registered">
                    </center>
                  </td>
                </tr>

              </table>
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