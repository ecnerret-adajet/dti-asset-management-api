<template>

</template>

<script>
import moment from "moment";

export default {

    methods: {
        dtFormat(value, format = 'LLL'){
            return moment(value).format(format);
        },

        numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },

        toCurrencyFormat(value, decimal = 2){
            let val = (value / 1).toFixed(decimal).replace(',', '.');
            val = val / 1;

            if (val > 0 && val < 1000){
                return val;
            }
            else{
                return this.numberWithCommas(val.toString());
            }
        },

        toastrBottom(message, status = 'success'){
            toastr.options = {"positionClass": "toast-bottom-right"}
            toastr[status](message);
        },

        storagePath(url){
            return '/storage/' + url;
        },

        toUrlEncode(url){
            return encodeURIComponent(encodeURIComponent(url));
        },

        getAttachment(documents, type){
            let value = documents.find(i => i.filename == type) ?? null;
            if (value){
                value = this.toUrlEncode(value.path);
            }
            return value;
        }
    }
}
</script>

<style scoped>

</style>
