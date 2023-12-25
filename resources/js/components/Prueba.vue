<template>

</template>
<script>
export default {
    data(){
        return{
            data : {
                from_date : '2023-12-25',
                to_date : '2024-03-24',
                origins : 'AUBNE',
                destinationCodeHidden : 'BDCGP'
            }
        }
    },
    created(){

        this.getResource()
    },
    methods:{
        getResource(){
            axios.post('https://www.wwalliance.com/wwaonline/sch/index.php', this.data).then(res=>{
                console.log(res.data)
            }).catch(error=>{
                console.log(error.response)
            })
        }
    }
}
</script>
