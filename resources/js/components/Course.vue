<template>

<div class="row">

   <div class="progress row">
      <div class="line" :style="'width:'+this.course.progress+'%'" ></div>
   </div>
   <div class="courses__block row col-md-12"> 
      <button  class="person__btn btn-hide">
         <a href="#">  
         <span>
            <i class="fa fa-angle-up"></i>
         </span>
         Раскрыть</a>
      </button>
      <img :src="course.image" alt="courses" class="img-responsive mx-auto d-block col-md-3">
      <div class="courses__elem col-md-9">
         <div class="courses__elem-up row">
            <div class="courses__txt col-md-10 col-sm-9">
               <p>
                  {{course.title}}
               </p>
               <div>
                  {{course.description}}
               </div>
            </div>
            <div class="courses__percent col-md-2 col-sm-3">
               <div>
                  {{course.progress}}%
               </div>
               <p>
                  изучено
               </p>
            </div>
         </div>
         <div class="courses__elem-down">
            <div class="courses__txt row">
               <span class="exp-span">
                  <i class="fa fa-check-circle"></i>
               </span>
               <p class="exp-prg">
                  {{course.total_classes}} занятий <br>( {{course.progress_completed_tasks}} выполнено)
               </p>
               <span class="exp-span">
                  <i class="fa fa-check-circle"></i>
               </span>
               <p class="exp-prg">
                  {{course.total_hours}} часов <br>обучения
               </p>
               <div class="courses__expert expert row">
                  <div class="expert__txt">
                     <div>
                        эксперт
                     </div>
                     <p>
                        Андрей Реутов
                     </p>
                  </div> 
                  <img src="images/expert.png" alt="courses" class="img-responsive mx-auto d-block">
               </div>
            </div>
         </div>
         </div>
      </div>
   </div>

</div>





</template>
<script>
export default {
  props: ["course"],
  computed: {
    style: function () {
      return "width:" + this.course.progress + "%";
    },
  },
  data() {
    return {
      progress: 38,
    };
  },
};
</script>
<style lang="scss">
.progress {
  width: 100%;
  height: 4px;
  background: #e6e6e6;
  margin-top: 30px;
  border-radius: 4px;
  .line {
    height: 100%;
    background: #fabe4b;
  }
}
</style>