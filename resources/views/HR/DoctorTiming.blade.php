@extends('Layouts.App')
@section('content') 

    <div class="row">
    
        <div class="col-sm-8">
            <div class="container bg card">
                <br>
                <h3>Set Doctor Appointment Timing</h3>
                <hr>
                <form method="POST">
                    <!-- CSRF Token Value -->
                    {{csrf_field()}}
                    <table width="100%">
                        <tr>
                            <td>Doctor ID</td>
                            <td>
                                <input type="text" name="dId"class="form-control" readonly value="{{$DoctorId}}">
                            </td>
                        </tr>

                        <tr>
                            <td>Doctor Name</td>
                            <td>
                                <input type="text" name="name" class="form-control" value="{{$Name}}" readonly>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Select Day
                            </td>
                            <td>
                                <select class="form-control" name="selectDay">
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
                            <td>
                                Shift
                            </td>
                            <td>
                                <select class="form-control" name="shift">
                                    <option>Morning</option>
                                    <option>Evening</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>starting Time</td>
                            <td>
                                <input type="time" name="startingTime" class="form-control" id="startingTime">
                            </td>
                        </tr>

                        <tr>
                            <td>Total Duration</td>
                            <td>
                                <input type="number" name="duration" class="form-control" id="duration">
                            </td>
                        </tr>

                        <tr>
                            <td>Ending Time</td>
                            <td>
                                <input type="text" readonly value="" class="form-control" id="endTime" name="endTime">
                            </td>
                        </tr>

                        <tr>
                            <td>Preset Time</td>
                            <td>
                                <input type="number" class="form-control" name="presetTime" id="presetTime">
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <!-- <a href="{{route('HR.schedule',$DoctorId)}}"> -->
                                <input type="submit" class="btn btn-success" value="Genarate Schedule" onclick="submit">
                                </a>
                            </td>
                        </tr>
                    </table>
                </form>
                <br>
            </div>
        </div>

        <!-- Doctor Appointment Time Show Div -->

        <div class="col-sm-4">
            <div class="container bg card">
                <br>
                <h6>{{$Name}}'s Time Slots</h6>
                <hr>
            </div>
        </div>
    </div>

    <!-- Jquery Code Here -->
    <script>
        $("#duration").keypress(function(){
            var startingTime = document.getElementById('startingTime').value;
            var duration     = document.getElementById('duration').value+0;
            var x            = 60;
            var getHour      = duration/x;
            var endHour      = parseInt(startingTime) + parseInt(getHour);
            
            //get Hour and Minute by using split function
            var getMin = startingTime.split(":");
            // alert(getMin[1]);
            if(endHour > 12){
                var newHour = endHour - 12;
                var amPm    = "PM";
            }
            else{
                var newHour = endHour;
                var amPm    = "AM";
            }
            
            if(newHour<10){
                newHour = '0'+newHour;
                console.log(newHour);
            }
            var time = newHour+":"+getMin[1]+" "+amPm;
            // console.log(time);
            $('#endTime').val(time);
            //Get Total Checking Patient
            // $("#presetTime").keypress(function(){
            //     var preset      = document.getElementById('presetTime').value+0;
            //     var duration    = document.getElementById('duration').value;
            //     var totalPatientChecked = duration/preset;
                
            //     console.log(totalPatientChecked);
            //     // document.getElementById('checkedPatient').text = totalPatientChecked;
            //     // $('#checkedPatient').val = totalPatientChecked; 
                
            // });
        });
    </script>

@endsection