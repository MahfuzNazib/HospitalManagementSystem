@extends('Layouts.App')
@section('content') 

    <div class="row">
    
        <div class="col-sm-10">
            <div class="container bg card">
                <br>
                <h3>Set Doctor Appointment Timing</h3>
                <hr>

                <table>
                    <tr>
                        <td>Doctor ID</td>
                        <td>
                            <input type="text" class="form-control" readonly value="{{$DoctorId}}">
                        </td>
                    </tr>

                    <tr>
                        <td>Doctor Name</td>
                        <td>
                            <input type="text" class="form-control" value="{{$Name}}" readonly>
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
                            <input type="text" readonly value="" class="form-control" id="endTime">
                            <!-- <text class="pclass" id="end"></text> -->
                        </td>
                    </tr>

                    <tr>
                        <td>Preset Time</td>
                        <td>
                            <input type="number" class="form-control" name="presetTime" id="presetTime">
                        </td>
                    </tr>

                    <tr>
                        <td>Total Patient</td>
                        <td>
                            <input type="number" name="totalPatient" readonly class="form-control" id="checkedPatient">
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" class="btn btn-success" value="Genarate Schedule">
                        </td>
                    </tr>
                </table>

                <br>
            </div>
        </div>
    </div>

    <!-- Jquery Code Here -->
    <script>
        $("#duration").change(function(){
            var startingTime = document.getElementById('startingTime').value;
            var duration = document.getElementById('duration').value;
            var x = 60;
            var getHour = duration/x;
            var endHour = parseInt(startingTime) + parseInt(getHour);
            
            //get Hour and Minute by using split function
            var getMin = startingTime.split(":");
            if(endHour > 12){
                var newHour = endHour - 12;
                var amPm = "PM";
            }
            else{
                var newHour = endHour;
                var amPm = "AM";
            }

            document.getElementById('endTime').value = newHour+":"+getMin[1]+" "+amPm;


            //Get Total Checking Patient

            $("#presetTime").change(function(){
                var preset = document.getElementById('presetTime').value;
                var duration = document.getElementById('duration').value;
                var totalPatientChecked = duration/preset;
                
                document.getElementById('checkedPatient').value = totalPatientChecked;
                // alert(totalPatientChecked);
            });
        });
    </script>

@endsection