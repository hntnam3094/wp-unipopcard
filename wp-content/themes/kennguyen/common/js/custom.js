$(function (){
    Download.init();
})

var Download = {
    init(){
        this.CustomerDownload()
        // this.loadMore()
    },

    CustomerDownload() {
        let customerId = $('.download-item').attr('data-iduser')
        let postId = $('.download-item').attr('data-idpost')
        let url = window.location.href
        $(document).delegate('.download-item', 'click', function () {
            if (customerId != '' && postId != '') {
                let data = {
                    'customerId': customerId,
                    'postId': postId
                }
                $.ajax({
                    url:url,
                    method:'post',
                    data:data,
                    dataType:'json',
                    success:function(data){
                        console.log(data)
                    }
                })
            }
        })
    },
    // loadMore() {
    //     let url = window.location.href
    //     $(document).delegate('.load-more-manager', 'click', function () {
    //         let data = {
    //             isLoadMore: true
    //         }
    //         $.ajax({
    //             url:url,
    //             method:'post',
    //             data:data,
    //             dataType:'json',
    //             success:function(data){
    //                 console.log(data)
    //             }
    //         })
    //     })
    // }
}




