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
                                @foreach($dept as $dept)
                                <option>
                                    {{ $dept['deptName'] }}
                                </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Doctors</td>
                        <td>
                            <!-- <input type="text" class="form-control" name="doctors" id="doctors"> -->
                            <select class="form-control" name="doctorName" id="dname">
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
                                <input type="submit" class="btn btn-info" value="Search Doctor Time" id="btnDrTime">
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
                    <text >Time Slots</text>
                </center>
                <hr>

                <table width="100%">
                    <tr>
                        <th>Shift</th>
                        <th>Time Slots</th>
                        <th>Action</th>
                    </tr>

                    <tr>
                        <td id="shift"></td>
                        <td id="times"></td>
                        
                    </tr>

                    
                </table>
            </div>
        </div>
    </div>

    <!-- AJAX code for Department wise Doctor List -->
    <script>
            $(document).ready(function(){

                $(document).on('change','#dept',function(){
                    var query = $(this).val();
                    console.log(query);
                    fetch_doctor_data(query);
                });
                var op=" ";
                var div = $(this).parent();
                function fetch_doctor_data(query = ''){
                    $.ajax({
                        url: "{{ route('Reception.action') }}",
                        method: 'GET',
                        data : {query : query},
                        success:function(data){
                            console.log('Success On DName Action')
                            console.log(data);
                            for(var i=0;i<data.length;i++){
                                op+='<option>'+data[i].Name+'</option>'
                            }

                            console.log(op);
                            $('#dname').html(op);
                        }
                        
                    })
                }

                //Get Doctor Appointment Time Based on Date

                $(document).on('change', '#date', function(){
                    var date = $('#date').val();
                    var name = $('#dname').val();
                    var dept = $('#dept').val();
                    console.log(name);
                    console.log(date);
                    console.log(dept);
                    fetch_doctor_time(name,date,dept);
                });

                var time = " ";
                var shift = " ";
                
                function fetch_doctor_time(name, date, dept){
                    $.ajax({
                        url: "{{ route('Reception.doctorDate') }}",
                        method: 'GET',
                        data : {date : date, name, dept },
                        success:function(data){
                            for(var i=0;i<data.length;i++){
                                shift+='<td>'+data[i].Shift+'</td>'
                                time+='<td>'+data[i].TimeSchedule+'</td><br>'
                            }
                            $('#shift').html(shift);
                            $('#times').html(time);
                            console.log(data);
                        }
                        
                    })
                }


            });
    </script>


@endsection