@extends('Layouts.App')
@section('content') 

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">New Notice Posting</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> View All Notices</a>
          </div>

      <!--Body Main Part-->

      <div class="row">
        <div class="col-sm-10">
          <div class="container bg card">
            <br><br>
              <table width="100%">
                
                <tr>
                  <td>Notice ID</td>
                  <td>
                    <input type="text"  readonly class="form-control" value="D-123455" name="nId">
                  </td>
                </tr>

                <tr>
                  <td>Date</td>
                  <td>
                    <input type="text" class="form-control" readonly value="" name="date">
                  </td>
                </tr>

                <tr>
                  <td>Title</td>
                  <td>
                    <input type="text" class="form-control" value="" name="title">
                  </td>
                </tr>

                <tr>
                  <td>Notice Body</td>
                  <td>
                    <textarea class="form-control">
                      
                    </textarea>
                  </td>
                </tr>

                

                <tr>
                  <td>Tag Pepoles</td>
                  <td>
                    <select class="form-control" name="tag">
                      <option>All</option>
                      <option>HR Dept</option>
                      <option>Doctors</option>
                      <option>Managers</option>
                      <option>Reciptionists</option>
                    </select>
                  </td>

                </tr>
  
                <tr>
                  <td>Additional File</td>
                  <td>
                    <input type="file"   name="file">
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <center>
                      <input type="submit" class="btn btn-info" value="Post">
                
                    </center>
                  </td>
                </tr>

              </table>
          </div>
        </div>
        <!-- <div class="col-sm-4">
          <div class="container bg card">
            Set a profile Picture
            <br>
            <img src="" height="150px" width="150px"> <br>
            
            <input type="file" class="btn btn-info" value="Select a Picture">
          </div>
        </div>
      </div> -->

      <!--End Of Body Main Part-->
@endsection