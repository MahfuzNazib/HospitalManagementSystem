@extends('Layouts.ReceptionApp')
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
                <div class="col-sm-7 bg card">
                    <div id="msg"></div>
                    <table width="100%">
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Patient ID</td>
                        <td>
                            <input type="text" name="pId" id="pId" class="form-control">
                        </td>
                    </tr>

                    <tr>
                        <td>Patient Type</td>
                        <td>
                            <select class="form-control">
                                <option selected disabled>Select Patient Type</option>
                                <option>Outdoor</option>
                                <option>Indoor</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Patient Name</td>
                        <td>
                            <input type="text" name="pName" id="pName" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>Patient Contact</td>
                        <td>
                            <input type="text" name="pContact" id="pContact" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>Patient Gender</td>
                        <td>
                            <select class="form-control" name="pGender">
                                <option selected disabled>Select Gender</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Patient Age</td>
                        <td>
                            <input type="number" name="pAge" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <center>
                            <a href="">
                                <input type="submit" class="btn btn-success" value="Registared">
                            </a>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    </table>
                </div>

                <!-- Related Doctor Information -->
                <div class="col-sm-5 bg card">
                    <table width="100%" class="table">
                        
                        <tr>
                            <td>Doctor Name</td>
                            <td>
                                <input type="text" id="dname" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td>Visited Date</td>
                            <td id="visitingDate"></td>
                        </tr>
                        <tr>
                            <td>Time</td>
                            <td id="visitingTime"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- AJAX CODE -->

    <script>
        $(document).ready(function(){
            
            $(document).on('change', '#pId', function(){
                var patientId = $(this).val();
                console.log(patientId);
                var noData = '';
                var patientName = '';
                var patientContact = '';
                var doctorName = '';
                var visitingDate = '';
                var vistingTime = '';
                var bookingDate = '';
                var emptyData = '';
                var msg = 'Maybe New Patient.Click Here To Appointment';


                $.ajax({
                    url: "{{ route('Reception.patientInfo') }}",
                    method: 'GET',
                    data:{data:noData,patientId},
                    success:function(data){
                        console.log(data);
                        patientName = '';
                        patientContact = '';
                        doctorInfo = '';

                        for(var i=0; i<data.length; i++){
                            if(data[i].patientName == undefined ){
                                patientName += emptyData;
                                patientContact += emptyData;
                                noData += '<div> <a href="/Appointment"> <strong> '+msg+' </strong> </a> </div>'
                                alert('No Record Found!!');
                                break;
                            }
                            else{
                                patientName += data[i].patientName;
                                patientContact += data[i].pContact;
                                
                                // Get Doctor Data
                                doctorName += data[i].drName
                            }
                        } 
                        console.log(doctorName);

                        $('#msg').html(noData);
                        $('#pName').val(patientName);
                        $('#pContact').val(patientContact);
                        $('#dname').val(doctorName);
                    }
                });
            });
        });
    </script>
@endsection