<template>
<div>
<ul>
   <li v-for="item in courses">
      <course :course="item"></course>
   </li>
</ul>
</div>
</template>
<script>


export default {
data(){
   return {
      courses: [
         {
            id:1,
            title:'Патология рефлексов, патологические рефлексы',
            image:'images/courses1.png',
            description: ' Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus.',
            progress: 33,
            total_classes: '14',
            progress_completed_tasks: '4',
            total_hours: '40'
         },
         {
            id:2,
            title:'Произвольные движения',
            image:'images/courses2.png',
            description: ' Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus.',
            progress: 84,
            total_classes: '14',
            progress_completed_tasks: '11',
            total_hours: '35'
         }
      ]
   }
},

//props:["courses"],

}
</script>