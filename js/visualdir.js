$(document).ready(function(){
    $("li").mouseover(function(){
        //$(this).css("border", "solid red 1px");
        var name = $(this).children().attr("data-name");
        var size = $(this).children().attr("data-size");
        var output1 = "Name = " + name;
        var output2 = "Size = " + (size/1024).toFixed(2) + "KB";
        $("div#detail1").text(output1);
        $("div#detail2").text(output2);
    });
            
    //var highlight_elem = "";
    $("li").toggle(function(){
        //if(highlight_elem) {
        $(".highlight").removeClass("highlight");
        //}
        $(this).addClass("highlight");
        var id = $(this).attr("id");
        $("#stickyinfo").show().css("top",40+(7*id)).html(
            "Name = "+$(this).children().attr("data-name")+
            "<br />Size = "+($(this).children().attr("data-size")/1024).toFixed(2) + "KB"
            );
        //$("#stickyinfo").show();
    //alert("ID = "+ $(this).attr("id"));
                
    },function(){
        $(this).removeClass("highlight");
    });
/*$("li").mouseout(function(){
                $(this).css("border","solid black 1px");
            });
            $("li").mouseover(function(){
                $(this).css("border","solid #ccc 1px");
            });*/
/*$("li").hover(function(){
                 
                 $(this).css("border","solid #ccc 1px");
            },
            function(){
                $(this).css("border","solid black 1px");
            });*/
});