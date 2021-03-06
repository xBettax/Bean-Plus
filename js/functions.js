$(document).ready(function(){
    $("#view").load("data/showTable.php").hide();
    $("#view").fadeIn("slow");

    $('#guardar').click(function(e){
        e.preventDefault();

        var codigo = $('#codigo').val();
        var totalin = $('#totalin').val();
        var totalout = $('#totalout').val();
        var code = $('#code').val();

        if(codigo != "" && totalin != "" && totalout != "" && code != ""){
            $.ajax({
                url:"data/addCorte.php",
                type: "POST",
                data: {codigo:codigo,totalin:totalin,totalout:totalout,code:code}
            }).done(function(data){
                $('#codigo').val('');
                $('#totalin').val('');
                $('#totalout').val('');
                $('#code').val('');
                $("#view").load("data/showTable.php").hide();  
                $("#view").fadeIn("slow");
                $('#modal').click();
                $('#nCorte').empty();
                var a = data.split(',');
                var out = "<tr>";
                for (let index = 0; index < a.length; index++) {
                    out += "<td>" + a[index] + "</td>";  
                }
                $('#nCorte').append(out + "</tr>");
            });
        }else{
            alert("Existen Campos Vacios.");
        }
        
    });

    $('#agregar').click(function(f){
        f.preventDefault();

        var codMaq = $('#codMaq').val();
        var idMaq = $('#idMaq').val();
        var local = $('#local').val();

        if(codMaq != "" && idMaq != "" && local != ""){
            $.ajax({
                url:"data/addMaquina.php",
                type: "POST",
                data: {codMaq:codMaq,idMaq:idMaq,local:local}
            }).done(function(data){
                alert("Maquina agregada exitosamente.");

            });
        }else{
            alert("Existen Campos Vacios.");
        }
        
    });

    $('#mover').click(function(h){
        h.preventDefault();

        var codigom = $('#codigom').val();
        var localm = $('#localm').val();

        if(codigom != "" && localm != ""){
            $.ajax({
                url:"data/moverMaq.php",
                type: "POST",
                data: {codigom:codigom,localm:localm}
            }).done(function(data){
                alert("Local Actualizado exitosamente.");    
            });
        }else{
            alert("Existen Campos Vacios.");
        }
        
    });

     $('#search').keyup(function(){
        var cod = $('#search').val();
        if(cod != ""){
            $.ajax({
                url:"data/showTable.php",
                type: "POST",
                data: {cod:cod}
            }).done(function(data){
                $('#view').empty();
                $('#view').append(data);
            });
        }else{
            $("#view").load("data/showTable.php").hide();
            $("#view").fadeIn("slow");
        }
    });
});