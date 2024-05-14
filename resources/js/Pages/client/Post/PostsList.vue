<script setup>
   import PostItem from "@/Pages/client/Post/PostItem.vue";

   const props = defineProps({
       posts : {
           type : Array
       }
   })

   const post1 = {
       user: {
           id : 1,
           name : 'Join Smith',
           avatar : 'https://randomuser.me/api/portraits/men/25.jpg'
       },
       media : [
           {
               id : 1,
               name : 'test1.png',
               url : 'https://picsum.photos/seed/picsum/300',
               mime : 'image/png'
           },
           {
               id : 2,
               name : 'test3.png',
               url : 'https://picsum.photos/seed/picsum/500',
               mime : 'image/png'
           },
           {
               id : 3,
               name : 'test3.png',
               url : 'https://picsum.photos/seed/picsum/800',
               mime : 'image/png'
           },
           {
               id : 3,
               name : 'test3.png',
               url : 'https://picsum.photos/seed/picsum/1000',
               mime : 'image/png'
           }
       ],
       body: 'Mùi hương có thể khiến kỉ niệm ùa về và thời tiết cũng thế 🌨️\n' +
           'Lần đầu mình qua Sydney du lịch năm 12 tuổi và lần thứ 2 qua Sydney học cấp 3 đều rơi vào mùa đông, ' +
           'vậy nên mỗi năm trời chuyển lạnh là mình lại nhớ y nguyên cái cảm giác mùa đông những năm ấy 😍\n' +
           'Mùa đông Sydney rất đẹp, không lạnh hơn Hà Nội mình đâu, nhưng trời cực xanh và nắng ấm nên dù lạnh vẫn thấy dễ chịu lắm. ' +
           'Rùi mình nhớ những hôm đi bộ một mình tới trường, cái gì cũng lạ lẫm, đi canteen nhìn đồ ăn nhanh thôi cũng phái lắm vì ở nhà khôn',
       created_at: '2023-11-19 15:12'

   }
   const post2 = {
       user: {
           id : 1,
           name : 'Join Smith',
           avatar : 'https://randomuser.me/api/portraits/men/25.jpg'
       },
       media : [
           {
               id : 1,
               name : 'test1.png',
               url : 'https://picsum.photos/seed/picsum/300',
               mime : 'image/png'
           }
       ],
       body: 'Rùi mình nhớ những hôm đi bộ một mình tới trường, cái gì cũng lạ lẫm',
       created_at: '2023-11-19 15:12'

   }
   const post3 = {
       user: {
           id : 1,
           name : 'Join Bin',
           avatar : 'https://randomuser.me/api/portraits/men/25.jpg'
       },
       group: {
           id : 1,
           name : 'Laravel Developer'
       },
       body: 'Mùi hương có thể khiến kỉ niệm ùa về và thời tiết cũng thế 🌨️\n' +
           'Lần đầu mình qua Sydney du lịch năm 12 tuổi và lần thứ 2 qua Sydney học cấp 3 đều rơi vào mùa đông, ' +
           'vậy nên mỗi năm trời chuyển lạnh là mình lại nhớ y nguyên cái cảm giác mùa đông những năm ấy 😍\n' +
           'Mùa đông Sydney rất đẹp, không lạnh hơn Hà Nội mình đâu, nhưng trời cực xanh và nắng ấm nên dù lạnh vẫn thấy dễ chịu lắm. ' +
           'Rùi mình nhớ những hôm đi bộ một mình tới trường, cái gì cũng lạ lẫm, đi canteen nhìn đồ ăn nhanh thôi cũng phái lắm vì ở nhà khôn',
       created_at: '2023-11-19 15:12'

   }
</script>

<template>
    <div class="flex flex-col gap-3">
        <PostItem v-for="post of props.posts" :post="post"/>
<!--        <PostItem :post="post2"/>-->
<!--        <PostItem :post="post3"/>-->
    </div>
</template>

<style scoped>

</style>
