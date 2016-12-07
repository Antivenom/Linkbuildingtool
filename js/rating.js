function ratingHover(id){
    if($("#rating").val() == "0" || id >= $("#rating").val()){
        if(id == 0){
            $("#star1").attr('class', 'fa fa-star-o');   
            $("#star2").attr('class', 'fa fa-star-o');  
            $("#star3").attr('class', 'fa fa-star-o');  
            $("#star4").attr('class', 'fa fa-star-o');  
            $("#star5").attr('class', 'fa fa-star-o');  
        }else if(id == 1){
            $("#star1").attr('class', 'fa fa-star');   
            $("#star2").attr('class', 'fa fa-star-o');  
            $("#star3").attr('class', 'fa fa-star-o');  
            $("#star4").attr('class', 'fa fa-star-o');  
            $("#star5").attr('class', 'fa fa-star-o');  
        }else if(id == 2){
            $("#star1").attr('class', 'fa fa-star');   
            $("#star2").attr('class', 'fa fa-star');  
            $("#star3").attr('class', 'fa fa-star-o');  
            $("#star4").attr('class', 'fa fa-star-o');  
            $("#star5").attr('class', 'fa fa-star-o');  
        }else if(id == 3){
            $("#star1").attr('class', 'fa fa-star');   
            $("#star2").attr('class', 'fa fa-star');  
            $("#star3").attr('class', 'fa fa-star');  
            $("#star4").attr('class', 'fa fa-star-o');  
            $("#star5").attr('class', 'fa fa-star-o');  
        }else if(id == 4){
            $("#star1").attr('class', 'fa fa-star');   
            $("#star2").attr('class', 'fa fa-star');  
            $("#star3").attr('class', 'fa fa-star');  
            $("#star4").attr('class', 'fa fa-star');  
            $("#star5").attr('class', 'fa fa-star-o');  
        }else if(id == 5){
            $("#star1").attr('class', 'fa fa-star');   
            $("#star2").attr('class', 'fa fa-star');  
            $("#star3").attr('class', 'fa fa-star');  
            $("#star4").attr('class', 'fa fa-star');  
            $("#star5").attr('class', 'fa fa-star');  
        }
    }else if(id == 0){
        ratingHover($("#rating").val());   
    }
}

function setRating(id){
    if(id >=1 && id <=5){
        $("#rating").val(id);
        ratingHover(id);
    }
}