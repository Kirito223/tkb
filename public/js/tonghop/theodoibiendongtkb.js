function loaddanhsachtruong() {
    var data = axios.get('getdstruong').then(function(response) {
        var data1 = response.data;
        var datas = data1.map(function(value, label) {
            let data = value;
            let stt = label + 1;
            var datas = Object.assign(data, {
                stt: stt.toString()
            });
            return datas;
        });
        $("#girddstruong").dxDataGrid({
            dataSource: datas,
            showBorders: true,
            paging: {
                pageSize: 30
            },
            /* xap xep */
            sorting: {
                mode: "multiple"
            },
            /* loc du lieu */
            // filterRow: {
            //  visible: true,
            //  applyFilter: "auto"
            // },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Tìm kiếm..."
            },
            pager: {
                showPageSizeSelector: true,
                allowedPageSizes: [10, 20, 30],
                showInfo: true
            },
            /* co dan cot */
            allowColumnResizing: true,
            columnResizingMode: "widget",
            columns: [{
                caption: "STT",
                dataField: "stt",
                width: 50,
            }, {
                caption: "Tên trường",
                dataField: "tentruong",
            }, {
                caption: "Cấp học",
                dataField: "caphoc",
                cellTemplate: function(element, info) {
                    var dulieucap = info.value;
                    var tencap;
                    if (dulieucap == 1) {
                        tencap = "Tiểu học";
                    } else if (dulieucap == 2) {
                        tencap = "Trung học cơ sở";
                    } else if (dulieucap == 3) {
                        tencap = "Trung học phổ thông";
                    }
                    $("<div>")
                        .appendTo(element)
                        .text(tencap);
                }
            }, {
                caption: "Số lớp",
                dataField: "demdslop"
            }, {
                caption: "Số giáo viên",
                dataField: "demdsgv"
            }, 
            // {
            //     caption: "Số học sinh",
            //     dataField: "demdsgv"
            // }, 
            {
                fixed: true,
                fixedPosition: "right",
                caption: "",
                cellTemplate: function(container, options) {
                    container.addClass("center");
                    $("<div>")
                        .dxButton({
                            template: function(e) {
                                return $('<i class="fa fa-eye"></i>');
                            },
                            onClick: function(e) {
                                $("#bangdstruong").collapse('toggle');
                                $("#hieuungcongtru").addClass("ft-plus").removeClass("ft-minus");;
                                $("#idtentruong").text(options.data.tentruong);
                                $("#idtentruonggv").text(options.data.tentruong);
                                $("#idtentruonglop").text(options.data.tentruong);
                                $('#idtruonggv').val(options.data.matruong);
                                $('#idtruonglop').val(options.data.matruong);
                                var datadsgv = options.data.danhsachgv;
                                var datadslop = options.data.danhsachlop;
                                var datadskhoi = options.data.danhsachkhoihoc;
                                loaddanhsachgv(datadsgv);
                                // loaddanhsachlop(datadslop);
                                loaddanhsachkhoilop(datadskhoi, datadslop);
                                document.getElementById("formxemtkb").style.display = "block";
                            },
                        })
                        .css('background-color', 'info')
                        .appendTo(container);
                },
                width: 50,
            }],
        });
    });
}


function loaddanhsachgv(datadsgv) {
    var datadsgv = datadsgv;
    var selectListGv = document.getElementById('idselectgv');
    $('#idselectgv').append("<option value='none' selected='' disabled=''></option>");
    for (var i = 0; i < datadsgv.length; i++) {
        var option = document.createElement("option");
        option.value = datadsgv[i].id;
        option.text = datadsgv[i].hovaten;
        selectListGv.appendChild(option);
    }
    $('#idselectgv').select2({
        width: '50%'
    });

    $('#idselectgv').on('change',function(){
        //đếm bảng tồn tại trong div
        var dembang = $('#divResults').children('table').length;
        for(let m=0;m<dembang;m++){
            $('#divResults').children('table').remove();
        }
        if($('#divResults').children('table').length == 0){
            document.getElementById("cardxeptkbgiaovien").style.display = "none";
        }
        $('#datepickerthang input').val('');
        $('#datepickernam input').val('');
        var sel = document.getElementById("idselectgv");
        var text= sel.options[sel.selectedIndex].text;
        var idgv = sel.options[sel.selectedIndex].value;
        $('#idgv').val(idgv);
        // var idtruonggv = $('#idtruonggv').val();
        $('#idtengv').text(text);
    });

}

function loaddanhsachkhoilop(datadskhoi, datadslop) {
    var datadskhoi = datadskhoi;
    var datadslop = datadslop;
    var selectListKhoi = document.getElementById('idselectkhoi');
    var selectListLop = document.getElementById('idselectlop');
    $('#idselectkhoi').append("<option value='none' selected='' disabled=''</option>");
    for (var i = 0; i < datadskhoi.length; i++) {
        var option = document.createElement("option");
        // option.value = datadskhoi[i].id;
        option.value = datadskhoi[i].tenkhoi;
        option.text = datadskhoi[i].tenkhoi;
        selectListKhoi.appendChild(option);
    }

    $('#idselectkhoi').on('change', function() {
        document.getElementById("cardxeptkblop").style.display = "none";
        $('#idselectlop').find('option').remove();
        $('#idselectlop').append("<option></option>");
        var datakhoi = $(this).val();
        for (var j = 0; j < datadslop.length; j++) {
            if (datadslop[j].khoi == datakhoi) {
                var optionLop = document.createElement("option");
                optionLop.value = datadslop[j].id;
                optionLop.text = datadslop[j].tenlop;
                selectListLop.appendChild(optionLop);
            }
        }
    });
    $('#idselectkhoi').select2({
        width: '50%'
    });
    $('#idselectlop').select2({
        width: '50%'
    });

    $('#idselectlop').on('change',function(){
        //đếm bảng tồn tại trong div
        var dembang = $('#divResultsLop').children('table').length;
        for(let m=0;m<dembang;m++){
            $('#divResultsLop').children('table').remove();
        }
        if($('#divResultsLop').children('table').length == 0){
            document.getElementById("cardxeptkblop").style.display = "none";
        }
        $('#datepickerthanglop input').val('');
        $('#datepickernamlop input').val('');
        var sel = document.getElementById("idselectlop");
        var text= sel.options[sel.selectedIndex].text;
        var idlop = sel.options[sel.selectedIndex].value;
        var idtruonglop = $('#idtruonglop').val();
        $('#idlop').val(idlop);
        $('#idtenlop').text(text);

        // $('#phanthantablelop').empty();
        // axios.get('getthoikhoabieulop').then(function (response) {
        //     var datatkblop = response.data;
        //     for(let i =0;i<datatkblop.length;i++){
        //         var demdslop = datatkblop[i].dslop.length;
        //         for(let j=0;j<demdslop;j++){ 
        //             if(datatkblop[i].matruong == idtruonglop && datatkblop[i].dslop[j].malop == idlop){

        //                 var phanthantablelop = document.getElementById("phanthantablelop");

        //                 var dsbuoi = datatkblop[i].dslop[j].dsbuoi;

        //                 var noidungbang = "";
        //                 for (let i = 0; i < dsbuoi.length; i++) {
        //                     var rowspan = 0;
        //                     var demdstiet = dsbuoi[i].dstiet.length;
        //                     rowspan += demdstiet;
        //                     noidungbang += "<tr><td style='color: red;' rowspan=" + parseInt(1 + rowspan) + ">" + dsbuoi[i].tenbuoi + "</td></tr>";
        //                     for (let j = 0; j < demdstiet; j++) {

        //                         var cotrong = '';
        //                         var theadthu = document.querySelectorAll('#tablexemtkblop thead tr .classthu');
        //                         for(var x=0;x<theadthu.length;x++){
        //                             var mathu = theadthu[x].id;
        //                             cotrong += "<td rowspan=" + 1 + " data-mabuoi= "+dsbuoi[i].mabuoi+" data-matiet="+dsbuoi[i].dstiet[j].tiet+" data-mathu="+mathu+" class='classoronglop'></td>";
        //                         }
                                    
        //                         noidungbang += "<tr>"
        //                         +"<td>"+ dsbuoi[i].dstiet[j].tiet + "</td>"
        //                         +cotrong
        //                         +"</tr>";

        //                     }
        //                 }
        //                 $("tbody#phanthantablelop").append(noidungbang);

        //                 var tbodycotrong = document.querySelectorAll('#tablexemtkblop tbody tr td.classoronglop');

        //                 for(let i=0;i<dsbuoi.length;i++){
        //                     var demtiet = dsbuoi[i].dstiet.length;
        //                     for(let j=0;j<demtiet;j++){
        //                         var demthu = dsbuoi[i].dstiet[j].dsthu.length;
        //                         for(let k=0;k<demthu;k++){
        //                             for(let m=0;m<tbodycotrong.length;m++){
        //                                 var mabuoi =tbodycotrong[m].dataset.mabuoi; 
        //                                 var matiet = tbodycotrong[m].dataset.matiet;
        //                                 var mathu = tbodycotrong[m].dataset.mathu;
        //                                 if(dsbuoi[i].mabuoi == mabuoi && dsbuoi[i].dstiet[j].tiet == matiet && dsbuoi[i].dstiet[j].dsthu[k].mathu == mathu){
        //                                     tbodycotrong[m].innerHTML = "<span style='white-space: nowrap;'>"+dsbuoi[i].dstiet[j].dsthu[k].dsmonhoc[0].tenmonhoc+' ('+dsbuoi[i].dstiet[j].dsthu[k].dsmonhoc[0].dsgiaovien[0].bidanh+')'+"</span>";
        //                                 }
        //                             }
        //                         }
        //                     }
        //                 }
        //                 document.getElementById("cardxeptkblop").style.display = "block";
        //                 // for(var i=0;i<tbodycotrong.length;i++){
        //                 //  if(tbodycotrong[i].innerHTML == ''){
        //                 //      tbodycotrong[i].innerHTML = "<span style='color:orange; white-space: nowrap;'>Nghỉ</span>";
        //                 //  }
        //                 // }        
        //             }
        //         }
                
        //     }   
                
        // });

        // var tbodylop = $("#tablexemtkblop tbody#phanthantablelop");
        // if(tbodylop.children().length == 0){
        //     document.getElementById("cardxeptkblop").style.display = "none";
        // }
        
    });

}

window.onload = function() {
    loaddanhsachtruong();
    $("#bangdstruong").on('show.bs.collapse', function() {
        document.getElementById("formxemtkb").style.display = "none";
        $('#idselectgv').find('option').remove();
        $('#idselectlop').find('option').remove();
        $('#idselectkhoi').find('option').remove();
        $('#xemtkbgiaovien').prop('checked', false);
        $('#xemtkblop').prop('checked', false);
        document.getElementById("cardselectgv").style.display = "none";
        document.getElementById("cardselectlop").style.display = "none";
        document.getElementById("cardxeptkbgiaovien").style.display = "none";
        document.getElementById("cardxeptkblop").style.display = "none";
        $('#datepickerthang input').val('');
        $('#datepickertuantu').val('');
        $('#datepickertuanden').val('');
        $('#datepickernam input').val('');
        $('#datepickerthanglop input').val('');
        $('#datepickertuantulop').val('');
        $('#datepickertuandenlop').val('');
        $('#datepickernamlop input').val('');
        $('#iddatetimetuan').prop('checked', false);
        $('#iddatetimethang').prop('checked', false);
        $('#iddatetimenam').prop('checked', false);
        $('#iddatetimetuanlop').prop('checked', false);
        $('#iddatetimethanglop').prop('checked', false);
        $('#iddatetimenamlop').prop('checked', false);
        document.getElementById("divtuan").style.display = "none";
        document.getElementById("divthang").style.display = "none";
        document.getElementById("divnam").style.display = "none";
        document.getElementById("divtuanlop").style.display = "none";
        document.getElementById("divthanglop").style.display = "none";
        document.getElementById("divnamlop").style.display = "none";
    });

    // $('#idselectgv').on('change', function() {
    //     var sel = document.getElementById("idselectgv");
    //     var text = sel.options[sel.selectedIndex].text;
    //     $('#idtengv').text(text);
    //     document.getElementById("cardxeptkbgiaovien").style.display = "block";
    // });

    // $('#idselectlop').on('change', function() {
    //     var sel = document.getElementById("idselectlop");
    //     var text = sel.options[sel.selectedIndex].text;
    //     $('#idtenlop').text(text);
    //     document.getElementById("cardxeptkblop").style.display = "block";
    // });
    $("#xemtkblop").change(function () {

        $('#idselectgv').val('none').trigger('change.select2');
    });

    $("#xemtkbgiaovien").change(function () {

        $('#idselectkhoi').val('none').trigger('change.select2');
        $('#idselectlop').val('none').trigger('change.select2');
    });

    //giáo viên
    $('#datepickertuantu').datepicker({
        autoclose: true,
        language: "vi",
        daysOfWeekDisabled: [0],
    });

    $('#datepickertuanden').datepicker({
        autoclose: true,
        language: "vi",
        daysOfWeekDisabled: [0],
    });

    $("#datepickerthang").datepicker({
        format: "mm/yyyy",
        orientation: "bottom",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true,
        language: "vi",
    });

    $("#datepickernam").datepicker({
        format: "yyyy",
        orientation: "bottom",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true,
        language: "vi",
    });

    $('#datepickertuantu').on('change', function() {
        var tungay = $(this).val();
        // const thangnam = $(this).val();
        // const date = moment(tungay, 'DD/MM/YYYY');
        $('#iddatatungay').text(tungay);
        // const thang = date.format('M');
        // const nam = date.format('YYYY');
        if (tungay != '') {
            $('#idtungay').text("(Từ ngày: " + tungay);
        } else {
            $('#idtungay').text('');
        }

    });

    $('#datepickertuanden').on('change', function() {
        var iddatatungay = $('#iddatatungay').text();
        var date_tungay = iddatatungay.split("/").reverse().join("-");
        var d1 = Date.parse(date_tungay);
        var denngay = $(this).val();
        var date_denngay = denngay.split("/").reverse().join("-");
        var d3 = Date.parse(date_denngay);

        //đếm bảng tồn tại trong div
        var dembang = $('#divResults').children('table').length;
        for(let m=0;m<dembang;m++){
            $('#divResults').children('table').remove();
        }
      
        var idtruonggv = $('#idtruonggv').val();
        var idgv = $('#idgv').val();

        $('#phanthantablegiaovien').empty();
        axios.get('getthoikhoabieugvtime').then(function (response) {
            var datatkbgv = response.data;
            for(let i =0;i<datatkbgv.length;i++){
                var demdsgv = datatkbgv[i].dsgiaovien.length;
                for(let j=0;j<demdsgv;j++){
                    var demthoigian = datatkbgv[i].dsgiaovien[j].dsthoigian.length
                    for(let k=0;k<demthoigian;k++){
                        var datangay = datatkbgv[i].dsgiaovien[j].dsthoigian[k].datangay;
                        var d2 = Date.parse(datangay);
                        if(datatkbgv[i].matruong == idtruonggv && datatkbgv[i].dsgiaovien[j].magiaovien == idgv && d1<=d2 && d2<=d3){
                            //tạo bảng
                            let taobang = document.createElement("table");
                            taobang.setAttribute("id","tablexemtkbgiaovien"+k+"");
                            taobang.setAttribute("class","table table-striped table-bordered dataex-key-basic table-responsive display nowrap");
                            taobang.setAttribute("style","overflow-y: auto; height: 100%;width: 100%;"); 
                            //tạo phần đầu
                            let taothead = document.createElement("thead");
                            taothead.setAttribute("style","background-color: #28386c;color: white;"); 

                            let taorow = document.createElement("tr");

                            let thbuoi = document.createElement("th");
                            thbuoi.appendChild(document.createTextNode('Buổi'));
                            taorow.appendChild(thbuoi);

                            let thtiet = document.createElement("th");
                            thtiet.appendChild(document.createTextNode('Tiết'));
                            taorow.appendChild(thtiet);

                            var thu= [
                                {
                                    'idthu':2,
                                    'tenthu':"Thứ 2"   
                                },
                                {
                                    'idthu':3,
                                    'tenthu':"Thứ 3"   
                                },
                                {
                                    'idthu':4,
                                    'tenthu':"Thứ 4"   
                                },
                                {
                                    'idthu':5,
                                    'tenthu':"Thứ 5"   
                                },
                                {
                                    'idthu':6,
                                    'tenthu':"Thứ 6"   
                                },
                                {
                                    'idthu':7,
                                    'tenthu':"Thứ 7"   
                                },
                            ];

                            for(let z=0;z<thu.length;z++){
                                let th = document.createElement("th");
                                let tenthu = document.createTextNode(' ' + thu[z].tenthu);
                                th.setAttribute("id",+thu[z].idthu);
                                th.setAttribute("class","classthu")
                                th.appendChild(tenthu);
                                taorow.appendChild(th);
                            }

                            taothead.append(taorow);

                            //tạo phần thân
                            let taotbody = document.createElement("tbody");
                            taotbody.setAttribute("id","phanthantablegiaovien"+k+"");

                            taobang.appendChild(taothead);
                            taobang.appendChild(taotbody);
                        
                            $('#divResults').append(taobang);
                            

                            var dsbuoi = datatkbgv[i].dsgiaovien[j].dsthoigian[k].dsbuoi;
                            var databuoi = [
                            {
                                "mabuoi":0,
                                "tenbuoi":"Sáng"
                            },{
                                "mabuoi":1,
                                "tenbuoi":"Chiều"
                            },
                            ];
                            var datatiet = [
                                {
                                    "tiet":1
                                },
                                {
                                    "tiet":2
                                },
                                {
                                    "tiet":3
                                },
                                {
                                    "tiet":4
                                },
                                {
                                    "tiet":5
                                },
                            ];
                            var noidungbang = "";
                            for (let i = 0; i < databuoi.length; i++) {
                                var rowspan = 0;
                                var demdatatiet = datatiet.length;
                                rowspan += demdatatiet;
                                noidungbang += "<tr><td style='color: red;' rowspan=" + parseInt(1 + rowspan) + ">" + databuoi[i].tenbuoi + "</td></tr>";
                                for (let j = 0; j < demdatatiet; j++) {

                                    var cotrong = '';
                                    var tablexemtkbgiaovien = 'tablexemtkbgiaovien'+k+'';
                                    var theadthu = document.querySelectorAll("table[id^="+tablexemtkbgiaovien+"] thead tr .classthu");
                                    for(var x=0;x<theadthu.length;x++){
                                        var mathu = theadthu[x].id;
                                        cotrong += "<td rowspan=" + 1 + " data-mabuoi= "+databuoi[i].mabuoi+" data-matiet="+datatiet[j].tiet+" data-mathu="+mathu+" class='classoronggiaovien'></td>";
                                    }
                                        
                                    noidungbang += "<tr>"
                                    +"<td>"+ datatiet[j].tiet + "</td>"
                                    +cotrong
                                    +"</tr>";

                                }
                            }

                            $('#phanthantablegiaovien'+k).append(noidungbang);

                            var tablexemtkbgiaovien = 'tablexemtkbgiaovien'+k;

                            var tbodycotrong = document.querySelectorAll("table[id^='tablexemtkbgiaovien'] tbody tr td.classoronggiaovien");

                            for(let i=0;i<dsbuoi.length;i++){
                                var demtiet = dsbuoi[i].dstiet.length;
                                for(let j=0;j<demtiet;j++){
                                    var demthu = dsbuoi[i].dstiet[j].dsthu.length;
                                    for(let k=0;k<demthu;k++){
                                        for(let m=0;m<tbodycotrong.length;m++){
                                            var mabuoi =tbodycotrong[m].dataset.mabuoi; 
                                            var matiet = tbodycotrong[m].dataset.matiet;
                                            var mathu = tbodycotrong[m].dataset.mathu;
                                            if(dsbuoi[i].mabuoi == mabuoi && dsbuoi[i].dstiet[j].tiet == matiet && dsbuoi[i].dstiet[j].dsthu[k].mathu == mathu){
                                                tbodycotrong[m].innerHTML = "<span style='white-space: nowrap;'>"+dsbuoi[i].dstiet[j].dsthu[k].dsmonhoc[0].tenmonhoc+' ('+dsbuoi[i].dstiet[j].dsthu[k].dsmonhoc[0].dslop[0].tenlop+')'+"</span>";
                                            }
                                        }
                                    }
                                }
                            }

                            document.getElementById("cardxeptkbgiaovien").style.display = "block";
                                  
                        }

                    }
                    
                }
                
            }   
                
        });
                
        if($('#divResults').children('table').length == 0){
            document.getElementById("cardxeptkbgiaovien").style.display = "none";
        }

        if (denngay != '') {
            $('#iddenngay').text(" - Đến ngày: " + denngay + ")");
        } else {
            $('#iddenngay').text('');
        }

    });

    $('#datepickerthang input').on('change', function() {

        //đếm bảng tồn tại trong div
        var dembang = $('#divResults').children('table').length;
        for(let m=0;m<dembang;m++){
            $('#divResults').children('table').remove();
        }
        const thangnam = $(this).val();
        const date = moment(thangnam, 'MM/YYYY');
        const thang = date.format('M');
        const nam = date.format('YYYY');
        
        var idtruonggv = $('#idtruonggv').val();
        var idgv = $('#idgv').val();

        $('#phanthantablegiaovien').empty();
        axios.get('getthoikhoabieugvtime').then(function (response) {
            var datatkbgv = response.data;
            for(let i =0;i<datatkbgv.length;i++){
                var demdsgv = datatkbgv[i].dsgiaovien.length;
                for(let j=0;j<demdsgv;j++){
                    var demthoigian = datatkbgv[i].dsgiaovien[j].dsthoigian.length
                    for(let k=0;k<demthoigian;k++){
                        if(datatkbgv[i].matruong == idtruonggv && datatkbgv[i].dsgiaovien[j].magiaovien == idgv && datatkbgv[i].dsgiaovien[j].dsthoigian[k].thang == thang && datatkbgv[i].dsgiaovien[j].dsthoigian[k].nam == nam){
                            //tạo bảng
                            let taobang = document.createElement("table");
                            taobang.setAttribute("id","tablexemtkbgiaovien"+k+"");
                            taobang.setAttribute("class","table table-striped table-bordered dataex-key-basic table-responsive display nowrap");
                            taobang.setAttribute("style","overflow-y: auto; height: 100%;width: 100%;"); 
                            //tạo phần đầu
                            let taothead = document.createElement("thead");
                            taothead.setAttribute("style","background-color: #28386c;color: white;"); 

                            let taorow = document.createElement("tr");

                            let thbuoi = document.createElement("th");
                            thbuoi.appendChild(document.createTextNode('Buổi'));
                            taorow.appendChild(thbuoi);

                            let thtiet = document.createElement("th");
                            thtiet.appendChild(document.createTextNode('Tiết'));
                            taorow.appendChild(thtiet);

                            var thu= [
                                {
                                    'idthu':2,
                                    'tenthu':"Thứ 2"   
                                },
                                {
                                    'idthu':3,
                                    'tenthu':"Thứ 3"   
                                },
                                {
                                    'idthu':4,
                                    'tenthu':"Thứ 4"   
                                },
                                {
                                    'idthu':5,
                                    'tenthu':"Thứ 5"   
                                },
                                {
                                    'idthu':6,
                                    'tenthu':"Thứ 6"   
                                },
                                {
                                    'idthu':7,
                                    'tenthu':"Thứ 7"   
                                },
                            ];

                            for(let z=0;z<thu.length;z++){
                                let th = document.createElement("th");
                                let tenthu = document.createTextNode(' ' + thu[z].tenthu);
                                th.setAttribute("id",+thu[z].idthu);
                                th.setAttribute("class","classthu")
                                th.appendChild(tenthu);
                                taorow.appendChild(th);
                            }

                            taothead.append(taorow);

                            //tạo phần thân
                            let taotbody = document.createElement("tbody");
                            taotbody.setAttribute("id","phanthantablegiaovien"+k+"");

                            taobang.appendChild(taothead);
                            taobang.appendChild(taotbody);
                        
                            $('#divResults').append(taobang);
                            

                            var dsbuoi = datatkbgv[i].dsgiaovien[j].dsthoigian[k].dsbuoi;

                            var databuoi = [
                            {
                                "mabuoi":0,
                                "tenbuoi":"Sáng"
                            },{
                                "mabuoi":1,
                                "tenbuoi":"Chiều"
                            },
                            ];
                            var datatiet = [
                                {
                                    "tiet":1
                                },
                                {
                                    "tiet":2
                                },
                                {
                                    "tiet":3
                                },
                                {
                                    "tiet":4
                                },
                                {
                                    "tiet":5
                                },
                            ];
                            var noidungbang = "";
                            for (let i = 0; i < databuoi.length; i++) {
                                var rowspan = 0;
                                var demdatatiet = datatiet.length;
                                rowspan += demdatatiet;
                                noidungbang += "<tr><td style='color: red;' rowspan=" + parseInt(1 + rowspan) + ">" + databuoi[i].tenbuoi + "</td></tr>";
                                for (let j = 0; j < demdatatiet; j++) {

                                    var cotrong = '';
                                    var tablexemtkbgiaovien = 'tablexemtkbgiaovien'+k+'';
                                    var theadthu = document.querySelectorAll("table[id^="+tablexemtkbgiaovien+"] thead tr .classthu");
                                    for(var x=0;x<theadthu.length;x++){
                                        var mathu = theadthu[x].id;
                                        cotrong += "<td rowspan=" + 1 + " data-mabuoi= "+databuoi[i].mabuoi+" data-matiet="+datatiet[j].tiet+" data-mathu="+mathu+" class='classoronggiaovien'></td>";
                                    }
                                        
                                    noidungbang += "<tr>"
                                    +"<td>"+ datatiet[j].tiet + "</td>"
                                    +cotrong
                                    +"</tr>";

                                }
                            }

                            $('#phanthantablegiaovien'+k).append(noidungbang);

                            var tablexemtkbgiaovien = 'tablexemtkbgiaovien'+k;

                            var tbodycotrong = document.querySelectorAll("table[id^='tablexemtkbgiaovien'] tbody tr td.classoronggiaovien");

                            for(let i=0;i<dsbuoi.length;i++){
                                var demtiet = dsbuoi[i].dstiet.length;
                                for(let j=0;j<demtiet;j++){
                                    var demthu = dsbuoi[i].dstiet[j].dsthu.length;
                                    for(let k=0;k<demthu;k++){
                                        for(let m=0;m<tbodycotrong.length;m++){
                                            var mabuoi =tbodycotrong[m].dataset.mabuoi; 
                                            var matiet = tbodycotrong[m].dataset.matiet;
                                            var mathu = tbodycotrong[m].dataset.mathu;
                                            if(dsbuoi[i].mabuoi == mabuoi && dsbuoi[i].dstiet[j].tiet == matiet && dsbuoi[i].dstiet[j].dsthu[k].mathu == mathu){
                                                tbodycotrong[m].innerHTML = "<span style='white-space: nowrap;'>"+dsbuoi[i].dstiet[j].dsthu[k].dsmonhoc[0].tenmonhoc+' ('+dsbuoi[i].dstiet[j].dsthu[k].dsmonhoc[0].dslop[0].tenlop+')'+"</span>";
                                            }
                                        }
                                    }
                                }
                            }

                            document.getElementById("cardxeptkbgiaovien").style.display = "block";
                                  
                        }

                    }
                    
                }
                
            }   
                
        });
                
        if($('#divResults').children('table').length == 0){
            document.getElementById("cardxeptkbgiaovien").style.display = "none";
        }

        if (thang != '') {
            $('#idthang').text("(Tháng: " + thang+ "/"+nam+ ")");
        } else {
            $('#idthang').text('');
        }

    });

    $('#datepickernam input').on('change', function() {
        //đếm bảng tồn tại trong div
        var dembang = $('#divResults').children('table').length;
        for(let m=0;m<dembang;m++){
            $('#divResults').children('table').remove();
        }
        const nam = $(this).val();
        
        var idtruonggv = $('#idtruonggv').val();
        var idgv = $('#idgv').val();

        $('#phanthantablegiaovien').empty();
        axios.get('getthoikhoabieugvtime').then(function (response) {
            var datatkbgv = response.data;
            for(let i =0;i<datatkbgv.length;i++){
                var demdsgv = datatkbgv[i].dsgiaovien.length;
                for(let j=0;j<demdsgv;j++){
                    var demthoigian = datatkbgv[i].dsgiaovien[j].dsthoigian.length
                    for(let k=0;k<demthoigian;k++){
                        if(datatkbgv[i].matruong == idtruonggv && datatkbgv[i].dsgiaovien[j].magiaovien == idgv && datatkbgv[i].dsgiaovien[j].dsthoigian[k].nam == nam){
                            //tạo bảng
                            let taobang = document.createElement("table");
                            taobang.setAttribute("id","tablexemtkbgiaovien"+k+"");
                            taobang.setAttribute("class","table table-striped table-bordered dataex-key-basic table-responsive display nowrap");
                            taobang.setAttribute("style","overflow-y: auto; height: 100%;width: 100%;"); 
                            //tạo phần đầu
                            let taothead = document.createElement("thead");
                            taothead.setAttribute("style","background-color: #28386c;color: white;"); 

                            let taorow = document.createElement("tr");

                            let thbuoi = document.createElement("th");
                            thbuoi.appendChild(document.createTextNode('Buổi'));
                            taorow.appendChild(thbuoi);

                            let thtiet = document.createElement("th");
                            thtiet.appendChild(document.createTextNode('Tiết'));
                            taorow.appendChild(thtiet);

                            var thu= [
                                {
                                    'idthu':2,
                                    'tenthu':"Thứ 2"   
                                },
                                {
                                    'idthu':3,
                                    'tenthu':"Thứ 3"   
                                },
                                {
                                    'idthu':4,
                                    'tenthu':"Thứ 4"   
                                },
                                {
                                    'idthu':5,
                                    'tenthu':"Thứ 5"   
                                },
                                {
                                    'idthu':6,
                                    'tenthu':"Thứ 6"   
                                },
                                {
                                    'idthu':7,
                                    'tenthu':"Thứ 7"   
                                },
                            ];

                            for(let z=0;z<thu.length;z++){
                                let th = document.createElement("th");
                                let tenthu = document.createTextNode(' ' + thu[z].tenthu);
                                th.setAttribute("id",+thu[z].idthu);
                                th.setAttribute("class","classthu")
                                th.appendChild(tenthu);
                                taorow.appendChild(th);
                            }

                            taothead.append(taorow);

                            //tạo phần thân
                            let taotbody = document.createElement("tbody");
                            taotbody.setAttribute("id","phanthantablegiaovien"+k+"");

                            taobang.appendChild(taothead);
                            taobang.appendChild(taotbody);
                        
                            $('#divResults').append(taobang);
                            

                            var dsbuoi = datatkbgv[i].dsgiaovien[j].dsthoigian[k].dsbuoi;

                            var databuoi = [
                            {
                                "mabuoi":0,
                                "tenbuoi":"Sáng"
                            },{
                                "mabuoi":1,
                                "tenbuoi":"Chiều"
                            },
                            ];
                            var datatiet = [
                                {
                                    "tiet":1
                                },
                                {
                                    "tiet":2
                                },
                                {
                                    "tiet":3
                                },
                                {
                                    "tiet":4
                                },
                                {
                                    "tiet":5
                                },
                            ];
                            var noidungbang = "";
                            for (let i = 0; i < databuoi.length; i++) {
                                var rowspan = 0;
                                var demdatatiet = datatiet.length;
                                rowspan += demdatatiet;
                                noidungbang += "<tr><td style='color: red;' rowspan=" + parseInt(1 + rowspan) + ">" + databuoi[i].tenbuoi + "</td></tr>";
                                for (let j = 0; j < demdatatiet; j++) {

                                    var cotrong = '';
                                    var tablexemtkbgiaovien = 'tablexemtkbgiaovien'+k+'';
                                    var theadthu = document.querySelectorAll("table[id^="+tablexemtkbgiaovien+"] thead tr .classthu");
                                    for(var x=0;x<theadthu.length;x++){
                                        var mathu = theadthu[x].id;
                                        cotrong += "<td rowspan=" + 1 + " data-mabuoi= "+databuoi[i].mabuoi+" data-matiet="+datatiet[j].tiet+" data-mathu="+mathu+" class='classoronggiaovien'></td>";
                                    }
                                        
                                    noidungbang += "<tr>"
                                    +"<td>"+ datatiet[j].tiet + "</td>"
                                    +cotrong
                                    +"</tr>";

                                }
                            }

                            $('#phanthantablegiaovien'+k).append(noidungbang);

                            var tablexemtkbgiaovien = 'tablexemtkbgiaovien'+k;

                            var tbodycotrong = document.querySelectorAll("table[id^='tablexemtkbgiaovien'] tbody tr td.classoronggiaovien");

                            for(let i=0;i<dsbuoi.length;i++){
                                var demtiet = dsbuoi[i].dstiet.length;
                                for(let j=0;j<demtiet;j++){
                                    var demthu = dsbuoi[i].dstiet[j].dsthu.length;
                                    for(let k=0;k<demthu;k++){
                                        for(let m=0;m<tbodycotrong.length;m++){
                                            var mabuoi =tbodycotrong[m].dataset.mabuoi; 
                                            var matiet = tbodycotrong[m].dataset.matiet;
                                            var mathu = tbodycotrong[m].dataset.mathu;
                                            if(dsbuoi[i].mabuoi == mabuoi && dsbuoi[i].dstiet[j].tiet == matiet && dsbuoi[i].dstiet[j].dsthu[k].mathu == mathu){
                                                tbodycotrong[m].innerHTML = "<span style='white-space: nowrap;'>"+dsbuoi[i].dstiet[j].dsthu[k].dsmonhoc[0].tenmonhoc+' ('+dsbuoi[i].dstiet[j].dsthu[k].dsmonhoc[0].dslop[0].tenlop+')'+"</span>";
                                            }
                                        }
                                    }
                                }
                            }

                            document.getElementById("cardxeptkbgiaovien").style.display = "block";
                                  
                        }

                    }
                    
                }
                
            }   
                
        });
                
        if($('#divResults').children('table').length == 0){
            document.getElementById("cardxeptkbgiaovien").style.display = "none";
        }

        if (nam != '') {
            $('#idnam').text("(Năm: " + nam + ")");
        } else {
            $('#idnam').text('');
        }

    });

    //lớp
    $('#datepickertuantulop').datepicker({
        autoclose: true,
        language: "vi",
        daysOfWeekDisabled: [0],

    });

    $('#datepickertuandenlop').datepicker({
        autoclose: true,
        language: "vi",
        daysOfWeekDisabled: [0],
    });

    $("#datepickerthanglop").datepicker({
        format: "mm/yyyy",
        orientation: "bottom",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true,
        language: "vi",
    });

    $("#datepickernamlop").datepicker({
        format: "yyyy",
        orientation: "bottom",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true,
        language: "vi",
    });

    $('#datepickertuantulop').on('change', function() {
        var tungay = $(this).val();
        $('#iddatatungaylop').text(tungay);
        if (tungay != '') {
            $('#idtungaylop').text("(Từ ngày: " + tungay);
        } else {
            $('#idtungaylop').text('');
        }

    });

    $('#datepickertuandenlop').on('change', function() {
        var iddatatungay = $('#iddatatungaylop').text();
        var date_tungay = iddatatungay.split("/").reverse().join("-");
        var d1 = Date.parse(date_tungay);
        var denngay = $(this).val();
        var date_denngay = denngay.split("/").reverse().join("-");
        var d3 = Date.parse(date_denngay);

        //đếm bảng tồn tại trong div
        var dembang = $('#divResultsLop').children('table').length;
        for(let m=0;m<dembang;m++){
            $('#divResultsLop').children('table').remove();
        }
      
        var idtruonglop = $('#idtruonglop').val();
        var idlop = $('#idlop').val();

        $('#phanthantablelop').empty();
        axios.get('getthoikhoabieuloptime').then(function (response) {
            var datatkblop = response.data;
            for(let i =0;i<datatkblop.length;i++){
                var demdslop = datatkblop[i].dslop.length;
                for(let j=0;j<demdslop;j++){
                    var demthoigian = datatkblop[i].dslop[j].dsthoigian.length
                    for(let k=0;k<demthoigian;k++){
                        var datangay = datatkblop[i].dslop[j].dsthoigian[k].datangay;
                        var d2 = Date.parse(datangay);
                        if(datatkblop[i].matruong == idtruonglop && datatkblop[i].dslop[j].malop == idlop && d1<=d2 && d2<=d3){
                            //tạo bảng
                            let taobang = document.createElement("table");
                            taobang.setAttribute("id","tablexemtkblop"+k+"");
                            taobang.setAttribute("class","table table-striped table-bordered dataex-key-basic table-responsive display nowrap");
                            taobang.setAttribute("style","overflow-y: auto; height: 100%;width: 100%;"); 
                            //tạo phần đầu
                            let taothead = document.createElement("thead");
                            taothead.setAttribute("style","background-color: #28386c;color: white;"); 

                            let taorow = document.createElement("tr");

                            let thbuoi = document.createElement("th");
                            thbuoi.appendChild(document.createTextNode('Buổi'));
                            taorow.appendChild(thbuoi);

                            let thtiet = document.createElement("th");
                            thtiet.appendChild(document.createTextNode('Tiết'));
                            taorow.appendChild(thtiet);

                            var thu= [
                                {
                                    'idthu':2,
                                    'tenthu':"Thứ 2"   
                                },
                                {
                                    'idthu':3,
                                    'tenthu':"Thứ 3"   
                                },
                                {
                                    'idthu':4,
                                    'tenthu':"Thứ 4"   
                                },
                                {
                                    'idthu':5,
                                    'tenthu':"Thứ 5"   
                                },
                                {
                                    'idthu':6,
                                    'tenthu':"Thứ 6"   
                                },
                                {
                                    'idthu':7,
                                    'tenthu':"Thứ 7"   
                                },
                            ];

                            for(let z=0;z<thu.length;z++){
                                let th = document.createElement("th");
                                let tenthu = document.createTextNode(' ' + thu[z].tenthu);
                                th.setAttribute("id",+thu[z].idthu);
                                th.setAttribute("class","classthu")
                                th.appendChild(tenthu);
                                taorow.appendChild(th);
                            }

                            taothead.append(taorow);

                            //tạo phần thân
                            let taotbody = document.createElement("tbody");
                            taotbody.setAttribute("id","phanthantablelop"+k+"");

                            taobang.appendChild(taothead);
                            taobang.appendChild(taotbody);
                        
                            $('#divResultsLop').append(taobang);
                            

                            var dsbuoi = datatkblop[i].dslop[j].dsthoigian[k].dsbuoi;
                            var databuoi = [
                            {
                                "mabuoi":0,
                                "tenbuoi":"Sáng"
                            },{
                                "mabuoi":1,
                                "tenbuoi":"Chiều"
                            },
                            ];
                            var datatiet = [
                                {
                                    "tiet":1
                                },
                                {
                                    "tiet":2
                                },
                                {
                                    "tiet":3
                                },
                                {
                                    "tiet":4
                                },
                                {
                                    "tiet":5
                                },
                            ];

                            var noidungbang = "";
                            for (let i = 0; i < databuoi.length; i++) {
                                var rowspan = 0;
                                var demdatatiet = datatiet.length;
                                rowspan += demdatatiet;
                                noidungbang += "<tr><td style='color: red;' rowspan=" + parseInt(1 + rowspan) + ">" + databuoi[i].tenbuoi + "</td></tr>";
                                for (let j = 0; j < demdatatiet; j++) {

                                    var cotrong = '';
                                    var tablexemtkblop = 'tablexemtkblop'+k+'';
                                    var theadthu = document.querySelectorAll("table[id^="+tablexemtkblop+"] thead tr .classthu");
                                    for(var x=0;x<theadthu.length;x++){
                                        var mathu = theadthu[x].id;
                                        cotrong += "<td rowspan=" + 1 + " data-mabuoi= "+databuoi[i].mabuoi+" data-matiet="+datatiet[j].tiet+" data-mathu="+mathu+" class='classoronglop'></td>";
                                    }
                                        
                                    noidungbang += "<tr>"
                                    +"<td>"+ datatiet[j].tiet + "</td>"
                                    +cotrong
                                    +"</tr>";

                                }
                            }

                            $('#phanthantablelop'+k).append(noidungbang);

                            var tablexemtkblop = 'tablexemtkblop'+k;

                            var tbodycotrong = document.querySelectorAll("table[id^='tablexemtkblop'] tbody tr td.classoronglop");

                            for(let i=0;i<dsbuoi.length;i++){
                                var demtiet = dsbuoi[i].dstiet.length;
                                for(let j=0;j<demtiet;j++){
                                    var demthu = dsbuoi[i].dstiet[j].dsthu.length;
                                    for(let k=0;k<demthu;k++){
                                        for(let m=0;m<tbodycotrong.length;m++){
                                            var mabuoi =tbodycotrong[m].dataset.mabuoi; 
                                            var matiet = tbodycotrong[m].dataset.matiet;
                                            var mathu = tbodycotrong[m].dataset.mathu;
                                            if(dsbuoi[i].mabuoi == mabuoi && dsbuoi[i].dstiet[j].tiet == matiet && dsbuoi[i].dstiet[j].dsthu[k].mathu == mathu){
                                                tbodycotrong[m].innerHTML = "<span style='white-space: nowrap;'>"+dsbuoi[i].dstiet[j].dsthu[k].dsmonhoc[0].tenmonhoc+' ('+dsbuoi[i].dstiet[j].dsthu[k].dsmonhoc[0].dsgiaovien[0].bidanh+')'+"</span>";
                                            }
                                        }
                                    }
                                }
                            }

                            document.getElementById("cardxeptkblop").style.display = "block";
                                  
                        }

                    }
                    
                }
                
            }   
                
        });
                
        if($('#divResultsLop').children('table').length == 0){
            document.getElementById("cardxeptkblop").style.display = "none";
        }

        if (denngay != '') {
            $('#iddenngaylop').text(" - Đến ngày: " + denngay + ")");
        } else {
            $('#iddenngaylop').text('');
        }

    });

    $('#datepickerthanglop input').on('change', function() {
        //đếm bảng tồn tại trong div
        var dembang = $('#divResults').children('table').length;
        for(let m=0;m<dembang;m++){
            $('#divResultsLop').children('table').remove();
        }
        const thangnam = $(this).val();
        const date = moment(thangnam, 'MM/YYYY');
        const thang = date.format('M');
        const nam = date.format('YYYY');
        
        var idtruonglop = $('#idtruonglop').val();
        var idlop = $('#idlop').val();

        $('#phanthantablelop').empty();
        axios.get('getthoikhoabieuloptime').then(function (response) {
            var datatkblop = response.data;
            for(let i =0;i<datatkblop.length;i++){
                var demdslop = datatkblop[i].dslop.length;
                for(let j=0;j<demdslop;j++){
                    var demthoigian = datatkblop[i].dslop[j].dsthoigian.length
                    for(let k=0;k<demthoigian;k++){
                        var datangay = datatkblop[i].dslop[j].dsthoigian[k].datangay;
                        var d2 = Date.parse(datangay);
                        if(datatkblop[i].matruong == idtruonglop && datatkblop[i].dslop[j].malop == idlop && datatkblop[i].dslop[j].dsthoigian[k].thang == thang && datatkblop[i].dslop[j].dsthoigian[k].nam == nam){
                            //tạo bảng
                            let taobang = document.createElement("table");
                            taobang.setAttribute("id","tablexemtkblop"+k+"");
                            taobang.setAttribute("class","table table-striped table-bordered dataex-key-basic table-responsive display nowrap");
                            taobang.setAttribute("style","overflow-y: auto; height: 100%;width: 100%;"); 
                            //tạo phần đầu
                            let taothead = document.createElement("thead");
                            taothead.setAttribute("style","background-color: #28386c;color: white;"); 

                            let taorow = document.createElement("tr");

                            let thbuoi = document.createElement("th");
                            thbuoi.appendChild(document.createTextNode('Buổi'));
                            taorow.appendChild(thbuoi);

                            let thtiet = document.createElement("th");
                            thtiet.appendChild(document.createTextNode('Tiết'));
                            taorow.appendChild(thtiet);

                            var thu= [
                                {
                                    'idthu':2,
                                    'tenthu':"Thứ 2"   
                                },
                                {
                                    'idthu':3,
                                    'tenthu':"Thứ 3"   
                                },
                                {
                                    'idthu':4,
                                    'tenthu':"Thứ 4"   
                                },
                                {
                                    'idthu':5,
                                    'tenthu':"Thứ 5"   
                                },
                                {
                                    'idthu':6,
                                    'tenthu':"Thứ 6"   
                                },
                                {
                                    'idthu':7,
                                    'tenthu':"Thứ 7"   
                                },
                            ];

                            for(let z=0;z<thu.length;z++){
                                let th = document.createElement("th");
                                let tenthu = document.createTextNode(' ' + thu[z].tenthu);
                                th.setAttribute("id",+thu[z].idthu);
                                th.setAttribute("class","classthu")
                                th.appendChild(tenthu);
                                taorow.appendChild(th);
                            }

                            taothead.append(taorow);

                            //tạo phần thân
                            let taotbody = document.createElement("tbody");
                            taotbody.setAttribute("id","phanthantablelop"+k+"");

                            taobang.appendChild(taothead);
                            taobang.appendChild(taotbody);
                        
                            $('#divResultsLop').append(taobang);
                            

                            var dsbuoi = datatkblop[i].dslop[j].dsthoigian[k].dsbuoi;
                            var databuoi = [
                            {
                                "mabuoi":0,
                                "tenbuoi":"Sáng"
                            },{
                                "mabuoi":1,
                                "tenbuoi":"Chiều"
                            },
                            ];
                            var datatiet = [
                                {
                                    "tiet":1
                                },
                                {
                                    "tiet":2
                                },
                                {
                                    "tiet":3
                                },
                                {
                                    "tiet":4
                                },
                                {
                                    "tiet":5
                                },
                            ];

                            var noidungbang = "";
                            for (let i = 0; i < databuoi.length; i++) {
                                var rowspan = 0;
                                var demdatatiet = datatiet.length;
                                rowspan += demdatatiet;
                                noidungbang += "<tr><td style='color: red;' rowspan=" + parseInt(1 + rowspan) + ">" + databuoi[i].tenbuoi + "</td></tr>";
                                for (let j = 0; j < demdatatiet; j++) {

                                    var cotrong = '';
                                    var tablexemtkblop = 'tablexemtkblop'+k+'';
                                    var theadthu = document.querySelectorAll("table[id^="+tablexemtkblop+"] thead tr .classthu");
                                    for(var x=0;x<theadthu.length;x++){
                                        var mathu = theadthu[x].id;
                                        cotrong += "<td rowspan=" + 1 + " data-mabuoi= "+databuoi[i].mabuoi+" data-matiet="+datatiet[j].tiet+" data-mathu="+mathu+" class='classoronglop'></td>";
                                    }
                                        
                                    noidungbang += "<tr>"
                                    +"<td>"+ datatiet[j].tiet + "</td>"
                                    +cotrong
                                    +"</tr>";

                                }
                            }

                            $('#phanthantablelop'+k).append(noidungbang);

                            var tablexemtkblop = 'tablexemtkblop'+k;

                            var tbodycotrong = document.querySelectorAll("table[id^='tablexemtkblop'] tbody tr td.classoronglop");

                            for(let i=0;i<dsbuoi.length;i++){
                                var demtiet = dsbuoi[i].dstiet.length;
                                for(let j=0;j<demtiet;j++){
                                    var demthu = dsbuoi[i].dstiet[j].dsthu.length;
                                    for(let k=0;k<demthu;k++){
                                        for(let m=0;m<tbodycotrong.length;m++){
                                            var mabuoi =tbodycotrong[m].dataset.mabuoi; 
                                            var matiet = tbodycotrong[m].dataset.matiet;
                                            var mathu = tbodycotrong[m].dataset.mathu;
                                            if(dsbuoi[i].mabuoi == mabuoi && dsbuoi[i].dstiet[j].tiet == matiet && dsbuoi[i].dstiet[j].dsthu[k].mathu == mathu){
                                                tbodycotrong[m].innerHTML = "<span style='white-space: nowrap;'>"+dsbuoi[i].dstiet[j].dsthu[k].dsmonhoc[0].tenmonhoc+' ('+dsbuoi[i].dstiet[j].dsthu[k].dsmonhoc[0].dsgiaovien[0].bidanh+')'+"</span>";
                                            }
                                        }
                                    }
                                }
                            }

                            document.getElementById("cardxeptkblop").style.display = "block";
                                  
                        }

                    }
                    
                }
                
            }   
                
        });
                
        if($('#divResultsLop').children('table').length == 0){
            document.getElementById("cardxeptkblop").style.display = "none";
        }

        if (thang != '') {
            $('#idthanglop').text("(Tháng: " + thang +"/"+nam+ ")");
        } else {
            $('#idthanglop').text('');
        }

    });

    $('#datepickernamlop input').on('change', function() {
        //đếm bảng tồn tại trong div
        var dembang = $('#divResults').children('table').length;
        for(let m=0;m<dembang;m++){
            $('#divResultsLop').children('table').remove();
        }
        const nam = $(this).val();
        
        var idtruonglop = $('#idtruonglop').val();
        var idlop = $('#idlop').val();

        $('#phanthantablelop').empty();
        axios.get('getthoikhoabieuloptime').then(function (response) {
            var datatkblop = response.data;
            for(let i =0;i<datatkblop.length;i++){
                var demdslop = datatkblop[i].dslop.length;
                for(let j=0;j<demdslop;j++){
                    var demthoigian = datatkblop[i].dslop[j].dsthoigian.length
                    for(let k=0;k<demthoigian;k++){
                        var datangay = datatkblop[i].dslop[j].dsthoigian[k].datangay;
                        var d2 = Date.parse(datangay);
                        if(datatkblop[i].matruong == idtruonglop && datatkblop[i].dslop[j].malop == idlop &&  datatkblop[i].dslop[j].dsthoigian[k].nam == nam){
                            //tạo bảng
                            let taobang = document.createElement("table");
                            taobang.setAttribute("id","tablexemtkblop"+k+"");
                            taobang.setAttribute("class","table table-striped table-bordered dataex-key-basic table-responsive display nowrap");
                            taobang.setAttribute("style","overflow-y: auto; height: 100%;width: 100%;"); 
                            //tạo phần đầu
                            let taothead = document.createElement("thead");
                            taothead.setAttribute("style","background-color: #28386c;color: white;"); 

                            let taorow = document.createElement("tr");

                            let thbuoi = document.createElement("th");
                            thbuoi.appendChild(document.createTextNode('Buổi'));
                            taorow.appendChild(thbuoi);

                            let thtiet = document.createElement("th");
                            thtiet.appendChild(document.createTextNode('Tiết'));
                            taorow.appendChild(thtiet);

                            var thu= [
                                {
                                    'idthu':2,
                                    'tenthu':"Thứ 2"   
                                },
                                {
                                    'idthu':3,
                                    'tenthu':"Thứ 3"   
                                },
                                {
                                    'idthu':4,
                                    'tenthu':"Thứ 4"   
                                },
                                {
                                    'idthu':5,
                                    'tenthu':"Thứ 5"   
                                },
                                {
                                    'idthu':6,
                                    'tenthu':"Thứ 6"   
                                },
                                {
                                    'idthu':7,
                                    'tenthu':"Thứ 7"   
                                },
                            ];

                            for(let z=0;z<thu.length;z++){
                                let th = document.createElement("th");
                                let tenthu = document.createTextNode(' ' + thu[z].tenthu);
                                th.setAttribute("id",+thu[z].idthu);
                                th.setAttribute("class","classthu")
                                th.appendChild(tenthu);
                                taorow.appendChild(th);
                            }

                            taothead.append(taorow);

                            //tạo phần thân
                            let taotbody = document.createElement("tbody");
                            taotbody.setAttribute("id","phanthantablelop"+k+"");

                            taobang.appendChild(taothead);
                            taobang.appendChild(taotbody);
                        
                            $('#divResultsLop').append(taobang);
                            

                            var dsbuoi = datatkblop[i].dslop[j].dsthoigian[k].dsbuoi;

                            var databuoi = [
                            {
                                "mabuoi":0,
                                "tenbuoi":"Sáng"
                            },{
                                "mabuoi":1,
                                "tenbuoi":"Chiều"
                            },
                            ];
                            var datatiet = [
                                {
                                    "tiet":1
                                },
                                {
                                    "tiet":2
                                },
                                {
                                    "tiet":3
                                },
                                {
                                    "tiet":4
                                },
                                {
                                    "tiet":5
                                },
                            ];

                            var noidungbang = "";
                            for (let i = 0; i < databuoi.length; i++) {
                                var rowspan = 0;
                                var demdatatiet = datatiet.length;
                                rowspan += demdatatiet;
                                noidungbang += "<tr><td style='color: red;' rowspan=" + parseInt(1 + rowspan) + ">" + databuoi[i].tenbuoi + "</td></tr>";
                                for (let j = 0; j < demdatatiet; j++) {

                                    var cotrong = '';
                                    var tablexemtkblop = 'tablexemtkblop'+k+'';
                                    var theadthu = document.querySelectorAll("table[id^="+tablexemtkblop+"] thead tr .classthu");
                                    for(var x=0;x<theadthu.length;x++){
                                        var mathu = theadthu[x].id;
                                        cotrong += "<td rowspan=" + 1 + " data-mabuoi= "+databuoi[i].mabuoi+" data-matiet="+datatiet[j].tiet+" data-mathu="+mathu+" class='classoronglop'></td>";
                                    }
                                        
                                    noidungbang += "<tr>"
                                    +"<td>"+ datatiet[j].tiet + "</td>"
                                    +cotrong
                                    +"</tr>";

                                }
                            }

                            $('#phanthantablelop'+k).append(noidungbang);

                            var tablexemtkblop = 'tablexemtkblop'+k;

                            var tbodycotrong = document.querySelectorAll("table[id^='tablexemtkblop'] tbody tr td.classoronglop");

                            for(let i=0;i<dsbuoi.length;i++){
                                var demtiet = dsbuoi[i].dstiet.length;
                                for(let j=0;j<demtiet;j++){
                                    var demthu = dsbuoi[i].dstiet[j].dsthu.length;
                                    for(let k=0;k<demthu;k++){
                                        for(let m=0;m<tbodycotrong.length;m++){
                                            var mabuoi =tbodycotrong[m].dataset.mabuoi; 
                                            var matiet = tbodycotrong[m].dataset.matiet;
                                            var mathu = tbodycotrong[m].dataset.mathu;
                                            if(dsbuoi[i].mabuoi == mabuoi && dsbuoi[i].dstiet[j].tiet == matiet && dsbuoi[i].dstiet[j].dsthu[k].mathu == mathu){
                                                tbodycotrong[m].innerHTML = "<span style='white-space: nowrap;'>"+dsbuoi[i].dstiet[j].dsthu[k].dsmonhoc[0].tenmonhoc+' ('+dsbuoi[i].dstiet[j].dsthu[k].dsmonhoc[0].dsgiaovien[0].bidanh+')'+"</span>";
                                            }
                                        }
                                    }
                                }
                            }

                            document.getElementById("cardxeptkblop").style.display = "block";
                                  
                        }

                    }
                    
                }
                
            }   
                
        });
                
        if($('#divResultsLop').children('table').length == 0){
            document.getElementById("cardxeptkblop").style.display = "none";
        }
        if (nam != '') {
            $('#idnamlop').text("(Năm: " + nam + ")");
        } else {
            $('#idnamlop').text('');
        }

    });
    
    // giáo viên
    $('#iddatetimetuan').on('change',function(){
        $('#datepickernam input').val('');
        $('#datepickerthang input').val('');
        var dembang = $('#divResults').children('table').length;
        for(let m=0;m<dembang;m++){
            $('#divResults').children('table').remove();
        }
        if($('#divResults').children('table').length == 0){
            document.getElementById("cardxeptkbgiaovien").style.display = "none";
        }
    });

    $('#iddatetimethang').on('change',function(){
        $('#datepickernam input').val('');
        $('#datepickertuantu').val('');
        $('#datepickertuanden').val('');
        var dembang = $('#divResults').children('table').length;
        for(let m=0;m<dembang;m++){
            $('#divResults').children('table').remove();
        }
        if($('#divResults').children('table').length == 0){
            document.getElementById("cardxeptkbgiaovien").style.display = "none";
        }
    });

    $('#iddatetimenam').on('change',function(){
        $('#datepickerthang input').val('');
        $('#datepickertuantu').val('');
        $('#datepickertuanden').val('');
        var dembang = $('#divResults').children('table').length;
        for(let m=0;m<dembang;m++){
            $('#divResults').children('table').remove();
        }
        if($('#divResults').children('table').length == 0){
            document.getElementById("cardxeptkbgiaovien").style.display = "none";
        }
    });

    // lớp
    $('#iddatetimetuanlop').on('change',function(){
        $('#datepickernamlop input').val('');
        $('#datepickerthanglop input').val('');
        var dembang = $('#divResultsLop').children('table').length;
        for(let m=0;m<dembang;m++){
            $('#divResultsLop').children('table').remove();
        }
        if($('#divResultsLop').children('table').length == 0){
            document.getElementById("cardxeptkblop").style.display = "none";
        }
    });

    $('#iddatetimethanglop').on('change',function(){
        $('#datepickernamlop input').val('');
        $('#datepickertuantulop').val('');
        $('#datepickertuandenlop').val('');
        var dembang = $('#divResultsLop').children('table').length;
        for(let m=0;m<dembang;m++){
            $('#divResultsLop').children('table').remove();
        }
        if($('#divResultsLop').children('table').length == 0){
            document.getElementById("cardxeptkblop").style.display = "none";
        }
    });

    $('#iddatetimenamlop').on('change',function(){
        $('#datepickerthanglop input').val('');
        $('#datepickertuantulop').val('');
        $('#datepickertuandenlop').val('');
        var dembang = $('#divResultsLop').children('table').length;
        for(let m=0;m<dembang;m++){
            $('#divResultsLop').children('table').remove();
        }
        if($('#divResultsLop').children('table').length == 0){
            document.getElementById("cardxeptkblop").style.display = "none";
        }
    });

    $("#xemtkblop").change(function () {

        $('#idselectgv').val('none').trigger('change.select2');
        $('#datepickerthang input').val('');
        $('#datepickertuantu').val('');
        $('#datepickertuanden').val('');
        $('#datepickernam input').val('');
        $('#iddatetimetuan').prop('checked', false);
        $('#iddatetimethang').prop('checked', false);
        $('#iddatetimenam').prop('checked', false);
        document.getElementById("divtuan").style.display = "none";
        document.getElementById("divthang").style.display = "none";
        document.getElementById("divnam").style.display = "none";

    });

    $("#xemtkbgiaovien").change(function () {

        $('#idselectkhoi').val('none').trigger('change.select2');
        $('#idselectlop').val('none').trigger('change.select2');
        $('#datepickerthanglop input').val('');
        $('#datepickertuantulop').val('');
        $('#datepickertuandenlop').val('');
        $('#datepickernamlop input').val('');
        $('#iddatetimetuanlop').prop('checked', false);
        $('#iddatetimethanglop').prop('checked', false);
        $('#iddatetimenamlop').prop('checked', false);
        document.getElementById("divtuanlop").style.display = "none";
        document.getElementById("divthanglop").style.display = "none";
        document.getElementById("divnamlop").style.display = "none";
    });

}