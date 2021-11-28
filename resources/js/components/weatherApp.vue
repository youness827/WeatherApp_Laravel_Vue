<template>
    <div>




            <div class="places-input text-gray-900">
                <!-- <input type="search" id="address" class="form-control font-sans w-128 max-x-lg p-5 overflow-hidden rounded-md font-bold text-lg outline-none" placeholder="Where are we going?" /> -->
                <input type="text"
                 id="address"
                 class="form-control rounded-lg outline-none
                 bg-gray-100 text-cool-gray-900 shadow-lg
                 font-bold font-sans text-lg uppercase"
                 placeholder="Where are we going?" />



            </div>

   <div class="weather-container font-sans w-128 max-w-lg overflow-hidden
    bg-gray-800 shadow-xl mt-4 text-white rounded-lg
    font-bold capitalize">
        <div class="flex items-center justify-between px-6 py-7">
        <div class="uppercase text-cool-gray-200
                    font-bold
                    text-xl">
                 current-weather
                 </div>
<!-- <div class="float-right text-cool-gray-200 font-semibold text-xl
            ">
         {{ location.formated}}

                   </div> -->


        </div>


        <div class="current-weather flex items-center justify-between px-6 py-8">

            <div class="flex items-center">
               <div>

                    <div class="text-6xl font-bold ">{{ currentTemperature.actual }}°C</div>
                    <div class="pt-2 font-bold">Feels Like {{currentTemperature.feels}}°C</div>
                    <div class="pt-2 font-bold text-gray-200">Humidity {{currentTemperature.humidity}} %</div>
                    <div class="pt-2 font-bold text-gray-200">Pressure  {{currentTemperature.pressure }} Hpa</div>


                </div>

                <div class="text-md mx-5 ">
                    <div class="font-semibold font-sans text-lg text-cool-gray-200">{{currentTemperature.description}}</div>
                    <div class="font-semibold font-sans text-lg text-cool-gray-200">{{location.name}}</div>
                </div>

            </div>







            <div>
                <img
            :src="currentTemperature.icon"
             />
            </div>
        </div> <!-- end current-weather -->

        <div class="future-weather text-lg bg-gray-400 p-5 overflow-hidden text-white font-bold capitalize">
            <div
             v-for="(day,index) in daily"
             :key="day.dt"
             class="flex items-center pt-4"
             v-if="index < 7 && index >0"

             >
                <div class="w-1/6 text-lg">{{toDayOfWeek(day.dt)}}</div>
                <div class="w-4/6 px-4 flex items-center">
                <div>
                    <img
                    :src="getIconDaily(day.weather[0].icon)"
                    />
                </div>
                <div class="ml-3">{{day.weather[0].description}}</div>
                </div>
                <div class="w-1/6 text-right">
                    <div>{{Math.round(day.temp.max)}} °C</div>
                    <div>{{Math.round(day.temp.min)}} °C</div>
                </div>

            </div>



        </div> <!-- end future-weather -->

    </div>   <!-- end weather-container -->

    </div>
</template>

<script>
    export default {
        mounted() {
     this.fetchData();
    this.fetchData_daily();
    // this.fetchTime();
  var placesAutocomplete = places({
       appId: 'plVXKLV5GWPG',
      apiKey: '62ac411694a472c6589c95bd0d8b4869',
    container: document.querySelector('#address')
  }).configure({
        type: 'city',
        aroundLatLngViaIP: false,
    });

  placesAutocomplete.on('change', e=>{
this.location.name=e.suggestion.country+", "+e.suggestion.name+", "+e.suggestion.postcode;
this.location.lat=e.suggestion.latlng.lat;
this.location.lon=e.suggestion.latlng.lng;

  });


        },
        watch:{
             location: {
                handler(val, oldVal) {
                    this.fetchData();
                        this.fetchData_daily();
                    //    this.fetchTime();

                 },
                deep: true
                }
        },

       data() {
           return {

               currentTemperature:{
                   actual:'',
                   feels:'',
                   description:'',
                   icon:'',
                   humidity:'',
                   pressure :''


               },
               location:{
                   name:'États-Unis d\'Amérique, Los Angeles, 90001',
              lat:'34.0537',
              lon:'-118.243',

               },
               daily:[]


           }
       },
        methods:{
            fetchData(){

              fetch(`/api/weather?lat=${this.location.lat}&lon=${this.location.lon}`)
                .then(response => response.json())
               .then(data => {
                   this.currentTemperature.actual =Math.round(data.main.temp);
                   this.currentTemperature.feels =Math.round(data.main.feels_like);
                   this.currentTemperature.description =data.weather[0].description;
                   this.currentTemperature.icon = `http://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png`
                   this.currentTemperature.humidity=data.main.humidity;
                    this.currentTemperature.pressure  = data.main.pressure ;

                   ;
                });
         },
         fetchData_daily(){
             fetch(`/api/dailyweather?lat=${this.location.lat}&lon=${this.location.lon}`)
             .then(response => response.json())
             .then(data =>{
                 this.daily = data.daily

             })
         },
         fetchTime(){
             fetch(`/api/time?lat=${this.location.lat}&lon=${this.location.lon}`)
             .then(response => response.json() )
             .then(data => {
                 this.location.formated = data.formatted;
             });
         },
         getIconDaily(day){
              const icondaily =`http://openweathermap.org/img/wn/${day}@2x.png`;
              return icondaily;
         },
         toDayOfWeek(timestamp){
             const dayofweeks = ['SUN','MON','TUE','WED','THU','FRI','SAT'];
             const newDate = new Date(timestamp*1000)

                return dayofweeks[newDate.getDay()];

         }

        }
    }
</script>
