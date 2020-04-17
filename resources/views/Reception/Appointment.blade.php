@extends('Layouts.ReceptionApp')
@section('content') 

    <center>
        <h2>Doctors Appointment </h2>
    </center>
    <div class="row">
        <div class="col-sm-6">
            <div class="container bg card">
                <table width="100%">
                    <tr>
                        <td>Department</td>
                        <td>
                            <select class="form-control" name="department" id="dept">
                                <option>Dental</option>
                                <option>Neourology</option>
                                <option>Heart</option>
                                <option>Cardiology</option>
                                <option>Ear,Nose & Tharot(ENT)</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Doctors</td>
                        <td>
                            <!-- <input type="text" class="form-control" name="doctors" id="doctors"> -->
                            <select class="form-control" name="doctorName">
                                <option>

                                </option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Date</td>
                        <td>
                            <input type="date" class="form-control" name="date" id="date">
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <a href="#">
                                <input type="submit" class="btn btn-info" value="Search Doctor Time">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td><u>Patient Information</u></td>
                    </tr>

                    <tr>
                        <td>Patient ID</td>
                        <td>
                            <input type="text" name="pId" id="pId" class="form-control">
                        </td>
                    </tr>

                    <tr>
                        <td>Patient Name</td>
                        <td>
                            <input type="text" name="pName" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>Patient Contact</td>
                        <td>
                            <input type="text" name="pContact" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>Patient Gender</td>
                        <td>
                            <select class="form-control" name="pGender">
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
                            <a href="#">
                                <input type="submit" class="btn btn-primary" value="Registered">
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Doctors Available Time Slot Shown Here -->
        <div class="col-sm-6">
            <div class="container bg card">
                <center>
                    <h5><i>14-02-2020 -- Doctor Time Shedule</i></h5>
                </center>
                <hr>

                <table width="100%">
                    <tr>
                        <th>Shift</th>
                        <th>Time Slots</th>
                        <th>Action</th>
                    </tr>

                    <tr>
                        <td>Morning</td>
                        <td>10:00 AM - 10:20 AM</td>
                        <td>
                            <a href="#">
                                <i class="fas fa-list-alt "></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Morning</td>
                        <td>10:00 AM - 10:20 AM</td>
                        <td>
                            <a href="#">
                                <i class="fas fa-list-alt "></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Morning</td>
                        <td>10:00 AM - 10:20 AM</td>
                        <td>
                            <a href="#">
                                <i class="fas fa-list-alt "></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Morning</td>
                        <td>10:00 AM - 10:20 AM</td>
                        <td>
                            <a href="#">
                                <i class="fas fa-list-alt "></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Morning</td>
                        <td>10:00 AM - 10:20 AM</td>
                        <td>
                            <a href="#">
                                <i class="fas fa-list-alt "></i>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Morning</td>
                        <td>10:00 AM - 10:20 AM</td>
                        <td>
                            <a href="#">
                                <i class="fas fa-list-alt "></i>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- AJAX code for Department wise Doctor List -->
    <script>
            $(document).ready(function(){

                function fetch_customer_data(query = ''){
                    $.ajax({
                        url: "{{ route('Reception.action') }}",
                        method: 'GET',
                        data : {query : query},
                        
                    })
                }

                // $(document).on('click', '#dept', function(){
                //     var query = $(this).val();
                //     console.log(query);
                //     fetch_customer_data(query);
                // });

                $("#pId").keyup(function()){
                    var query = $(this).val();
                    console.log(query);
                }

            });
    </script>


@endsection