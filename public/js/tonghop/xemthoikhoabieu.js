function loaddanhsachtruong() {
	var data = axios.get('getdstruong').then(function (response) {
		var data1 = response.data;
		var datas = data1.map(function (value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {stt: stt.toString()});
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
		// 	visible: true,
		// 	applyFilter: "auto"
		// },
		searchPanel: {
			visible: true,
			width: 240,
			placeholder: "Tìm kiếm..."
		},
		pager: {
			showPageSizeSelector: true,
			allowedPageSizes: [10,20,30],
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
		},	{
			caption: "Cấp học",
			dataField: "caphoc",
			cellTemplate: function(element, info) {
				var dulieucap = info.value;
				var tencap;
				if(dulieucap == 1){
					tencap = "Tiểu học";
				}else if(dulieucap == 2){
					tencap = "Trung học cơ sở";
				}else if(dulieucap == 3){
					tencap = "Trung học phổ thông";
				}
				$("<div>")
                .appendTo(element)
                .text(tencap);
			}	
		},	{
			caption:"Số lớp",
			dataField: "demdslop"
		},	{
			caption:"Số giáo viên",
			dataField: "demdsgv"
		},
		// {
		// 	caption:"Số học sinh",
		// 	dataField: "demdsgv"
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
                        	var matruong = options.data.matruong;
                        	loadthoikhoabieutruong(matruong);
                        	loadthoikhoabieutruongsang(matruong);
                        	loadthoikhoabieutruongchieu(matruong);
                        	loaddanhsachgv(datadsgv);
                        	// loaddanhsachlop(datadslop);
                        	loaddanhsachkhoilop(datadskhoi,datadslop);
                        	loadbanggiaovien(matruong);
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

//sáng và chiều
function loadthoikhoabieutruong(matruong){
	$('#phandautabletruong').empty();
	$('#phanthantabletruong').empty();
	var idtruong = matruong;
	axios.get('getthoikhoabieutruong').then(function (response) {
		var datatkb = response.data;
		axios.get('getdsloptruong').then(function (response1) {
			var dataloptruong = response1.data;
			for(let i =0;i<datatkb.length;i++){
				for(let j = 0; j<dataloptruong.length;j++){
					if(datatkb[i].matruong == idtruong && dataloptruong[j].matruong == idtruong){
						var datalop = dataloptruong[j].dslop;
						var phandautabletruong = document.getElementById("phandautabletruong");
						var phanthantabletruong = document.getElementById("phanthantabletruong");

						var ththu = document.createElement("th");
						ththu.setAttribute("class","stickyThu");
						ththu.appendChild(document.createTextNode('Thứ'));
						phandautabletruong.appendChild(ththu);

						var thtiet = document.createElement("th");
						thtiet.setAttribute("class","stickyTiet");
						thtiet.appendChild(document.createTextNode('Tiết'));
						phandautabletruong.appendChild(thtiet);

						for(var k=0;k<datalop.length;k++){
							var th = document.createElement("th");
							var tenlop = document.createTextNode(' ' + datalop[k].tenlop);
						    th.setAttribute("id",+datalop[k].malop);
						    th.setAttribute("class","classlop")
						    th.appendChild(tenlop);
						    phandautabletruong.appendChild(th);
						}

						var dsbuoithu = datatkb[i].dsbuoithu;

				  		var noidungbang = "";
				  		// var databuoithu = [
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":2,
				  		// 		"mabuoithu":"0,2",
				  		// 		"tenbuoithu":"Sáng thứ 2"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":3,
				  		// 		"mabuoithu":"0,3",
				  		// 		"tenbuoithu":"Sáng thứ 3"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":4,
				  		// 		"mabuoithu":"0,4",
				  		// 		"tenbuoithu":"Sáng thứ 4"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":5,
				  		// 		"mabuoithu":"0,5",
				  		// 		"tenbuoithu":"Sáng thứ 5"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":6,
				  		// 		"mabuoithu":"0,6",
				  		// 		"tenbuoithu":"Sáng thứ 6"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":7,
				  		// 		"mabuoithu":"0,7",
				  		// 		"tenbuoithu":"Sáng thứ 7"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":2,
				  		// 		"mabuoithu":"1,2",
				  		// 		"tenbuoithu":"Chiều thứ 2"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":3,
				  		// 		"mabuoithu":"1,3",
				  		// 		"tenbuoithu":"Chiều thứ 3"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":4,
				  		// 		"mabuoithu":"1,4",
				  		// 		"tenbuoithu":"Chiều thứ 4"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":5,
				  		// 		"mabuoithu":"1,5",
				  		// 		"tenbuoithu":"Chiều thứ 5"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":6,
				  		// 		"mabuoithu":"1,6",
				  		// 		"tenbuoithu":"Chiều thứ 6"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":7,
				  		// 		"mabuoithu":"1,7",
				  		// 		"tenbuoithu":"Chiều thứ 7"
				  		// 	},
				  		// ];
				  		var databuoithu = [
				  			{
				  				"mabuoi":0,
				  				"mathu":2,
				  				"mabuoithu":"0,2",
				  				"tenbuoithu":"Sáng thứ 2"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":2,
				  				"mabuoithu":"1,2",
				  				"tenbuoithu":"Chiều thứ 2"
				  			},
				  			{
				  				"mabuoi":0,
				  				"mathu":3,
				  				"mabuoithu":"0,3",
				  				"tenbuoithu":"Sáng thứ 3"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":3,
				  				"mabuoithu":"1,3",
				  				"tenbuoithu":"Chiều thứ 3"
				  			},
				  			{
				  				"mabuoi":0,
				  				"mathu":4,
				  				"mabuoithu":"0,4",
				  				"tenbuoithu":"Sáng thứ 4"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":4,
				  				"mabuoithu":"1,4",
				  				"tenbuoithu":"Chiều thứ 4"
				  			},
				  			{
				  				"mabuoi":0,
				  				"mathu":5,
				  				"mabuoithu":"0,5",
				  				"tenbuoithu":"Sáng thứ 5"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":5,
				  				"mabuoithu":"1,5",
				  				"tenbuoithu":"Chiều thứ 5"
				  			},
				  			{
				  				"mabuoi":0,
				  				"mathu":6,
				  				"mabuoithu":"0,6",
				  				"tenbuoithu":"Sáng thứ 6"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":6,
				  				"mabuoithu":"1,6",
				  				"tenbuoithu":"Chiều thứ 6"
				  			},
				  			{
				  				"mabuoi":0,
				  				"mathu":7,
				  				"mabuoithu":"0,7",
				  				"tenbuoithu":"Sáng thứ 7"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":7,
				  				"mabuoithu":"1,7",
				  				"tenbuoithu":"Chiều thứ 7"
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
				  		for (let i = 0; i < databuoithu.length; i++) {
				            var rowspan = 0;
				            var demdatatiet = datatiet.length;
				            rowspan += demdatatiet;
				            noidungbang += "<tr><td class='sticky-col first-col' style='color: red;' rowspan=" + parseInt(1 + rowspan) + ">" + databuoithu[i].tenbuoithu + "</td></tr>";
				            for (let j = 0; j < demdatatiet; j++) {

							  	var cotrong = '';
							  	var theadlop = document.querySelectorAll('#tablexemtkbtruong thead tr .classlop');
		                    	for(var x=0;x<theadlop.length;x++){
		                    		var idlop = theadlop[x].id;
						            cotrong += "<td rowspan=" + 1 + " data-mabuoithu = "+databuoithu[i].mabuoithu+" data-matiet="+datatiet[j].tiet+" data-malop="+idlop+" class='classorongtruong'></td>";
							  	}
  		                    	
			                    noidungbang += "<tr>"
			                    +"<td class='sticky-col second-col'>"+ datatiet[j].tiet + "</td>"
			                    +cotrong
			                    +"</tr>";

				            }

				        }
				        $("tbody#phanthantabletruong").append(noidungbang);

				        var tbodycotrong = document.querySelectorAll('#tablexemtkbtruong tbody tr td.classorongtruong');

				        for(let i=0;i<dsbuoithu.length;i++){
				        	var demtiet = dsbuoithu[i].dstiet.length;
				        	for(let j=0;j<demtiet;j++){
				        		var demlop = dsbuoithu[i].dstiet[j].dslop.length;
				        		for(let k=0;k<demlop;k++){
				        			for(let m=0;m<tbodycotrong.length;m++){
				        				var mabuoithu =tbodycotrong[m].dataset.mabuoithu; 
				        				var matiet = tbodycotrong[m].dataset.matiet;
				        				var malop = tbodycotrong[m].dataset.malop;
				        				if(dsbuoithu[i].mabuoithu == mabuoithu && dsbuoithu[i].dstiet[j].tiet == matiet && dsbuoithu[i].dstiet[j].dslop[k].malop == malop){
				        					var magiaovien = dsbuoithu[i].dstiet[j].dslop[k].dsmonhoc[0].dsgiaovien[0].magiaovien;
				        					tbodycotrong[m].innerHTML = "<span data-magiaovien="+magiaovien+" style='white-space: nowrap;'>"+dsbuoithu[i].dstiet[j].dslop[k].dsmonhoc[0].tenmonhoc+' ('+dsbuoithu[i].dstiet[j].dslop[k].dsmonhoc[0].dsgiaovien[0].bidanh+')'+"</span>";
				        				}
				        			}
				        		}
				        	}
				        }

				        // for(var i=0;i<tbodycotrong.length;i++){
				        // 	if(tbodycotrong[i].innerHTML == ''){
				        // 		tbodycotrong[i].innerHTML = "<span style='color:orange; white-space: nowrap;'>Nghỉ</span>";
				        // 	}
				        // }
				        	
					}
				}
			}
		});
	});

	
}

//sáng
function loadthoikhoabieutruongsang(matruong){
	$('#phandautabletruongsang').empty();
	$('#phanthantabletruongsang').empty();
	var idtruong = matruong;
	axios.get('getthoikhoabieutruong').then(function (response) {
		var datatkb = response.data;
		axios.get('getdsloptruong').then(function (response1) {
			var dataloptruong = response1.data;
			for(let i =0;i<datatkb.length;i++){
				for(let j = 0; j<dataloptruong.length;j++){
					if(datatkb[i].matruong == idtruong && dataloptruong[j].matruong == idtruong){
						var datalop = dataloptruong[j].dslop;

						var phandautabletruongsang = document.getElementById("phandautabletruongsang");
						var phanthantabletruongsang = document.getElementById("phanthantabletruongsang");

						var ththu = document.createElement("th");
						ththu.setAttribute("class","stickyThu");
						ththu.appendChild(document.createTextNode('Thứ'));
						phandautabletruongsang.appendChild(ththu);

						var thtiet = document.createElement("th");
						thtiet.setAttribute("class","stickyTiet");
						thtiet.appendChild(document.createTextNode('Tiết'));
						phandautabletruongsang.appendChild(thtiet);

						for(var k=0;k<datalop.length;k++){
							var th = document.createElement("th");
							var tenlop = document.createTextNode(' ' + datalop[k].tenlop);
						    th.setAttribute("id",+datalop[k].malop);
						    th.setAttribute("class","classlop")
						    th.appendChild(tenlop);
						    phandautabletruongsang.appendChild(th);
						}

						var dsbuoithu = datatkb[i].dsbuoithu;

						var noidungbang = "";
				  		// var databuoithu = [
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":2,
				  		// 		"mabuoithu":"0,2",
				  		// 		"tenbuoithu":"Sáng thứ 2"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":3,
				  		// 		"mabuoithu":"0,3",
				  		// 		"tenbuoithu":"Sáng thứ 3"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":4,
				  		// 		"mabuoithu":"0,4",
				  		// 		"tenbuoithu":"Sáng thứ 4"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":5,
				  		// 		"mabuoithu":"0,5",
				  		// 		"tenbuoithu":"Sáng thứ 5"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":6,
				  		// 		"mabuoithu":"0,6",
				  		// 		"tenbuoithu":"Sáng thứ 6"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":7,
				  		// 		"mabuoithu":"0,7",
				  		// 		"tenbuoithu":"Sáng thứ 7"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":2,
				  		// 		"mabuoithu":"1,2",
				  		// 		"tenbuoithu":"Chiều thứ 2"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":3,
				  		// 		"mabuoithu":"1,3",
				  		// 		"tenbuoithu":"Chiều thứ 3"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":4,
				  		// 		"mabuoithu":"1,4",
				  		// 		"tenbuoithu":"Chiều thứ 4"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":5,
				  		// 		"mabuoithu":"1,5",
				  		// 		"tenbuoithu":"Chiều thứ 5"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":6,
				  		// 		"mabuoithu":"1,6",
				  		// 		"tenbuoithu":"Chiều thứ 6"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":7,
				  		// 		"mabuoithu":"1,7",
				  		// 		"tenbuoithu":"Chiều thứ 7"
				  		// 	},
				  		// ];
				  		var databuoithu = [
				  			{
				  				"mabuoi":0,
				  				"mathu":2,
				  				"mabuoithu":"0,2",
				  				"tenbuoithu":"Sáng thứ 2"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":2,
				  				"mabuoithu":"1,2",
				  				"tenbuoithu":"Chiều thứ 2"
				  			},
				  			{
				  				"mabuoi":0,
				  				"mathu":3,
				  				"mabuoithu":"0,3",
				  				"tenbuoithu":"Sáng thứ 3"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":3,
				  				"mabuoithu":"1,3",
				  				"tenbuoithu":"Chiều thứ 3"
				  			},
				  			{
				  				"mabuoi":0,
				  				"mathu":4,
				  				"mabuoithu":"0,4",
				  				"tenbuoithu":"Sáng thứ 4"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":4,
				  				"mabuoithu":"1,4",
				  				"tenbuoithu":"Chiều thứ 4"
				  			},
				  			{
				  				"mabuoi":0,
				  				"mathu":5,
				  				"mabuoithu":"0,5",
				  				"tenbuoithu":"Sáng thứ 5"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":5,
				  				"mabuoithu":"1,5",
				  				"tenbuoithu":"Chiều thứ 5"
				  			},
				  			{
				  				"mabuoi":0,
				  				"mathu":6,
				  				"mabuoithu":"0,6",
				  				"tenbuoithu":"Sáng thứ 6"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":6,
				  				"mabuoithu":"1,6",
				  				"tenbuoithu":"Chiều thứ 6"
				  			},
				  			{
				  				"mabuoi":0,
				  				"mathu":7,
				  				"mabuoithu":"0,7",
				  				"tenbuoithu":"Sáng thứ 7"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":7,
				  				"mabuoithu":"1,7",
				  				"tenbuoithu":"Chiều thứ 7"
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
				  		for (let i = 0; i < databuoithu.length; i++) {
				            if(databuoithu[i].mabuoi == 0){
				  				var rowspan = 0;
					            var demdatatiet = datatiet.length;
					            rowspan += demdatatiet;
					            noidungbang += "<tr><td class='sticky-col first-col' style='color: red;' rowspan=" + parseInt(1 + rowspan) + ">" + databuoithu[i].tenbuoithu + "</td></tr>";
					            for (let j = 0; j < demdatatiet; j++) {

								  	var cotrong = '';
								  	var theadlop = document.querySelectorAll('#tablexemtkbtruong thead tr .classlop');
			                    	for(var x=0;x<theadlop.length;x++){
			                    		var idlop = theadlop[x].id;
							            cotrong += "<td rowspan=" + 1 + " data-mabuoithu = "+databuoithu[i].mabuoithu+" data-matiet="+datatiet[j].tiet+" data-malop="+idlop+" class='classorongtruong'></td>";
								  	}
	  		                    	
				                    noidungbang += "<tr>"
				                    +"<td class='sticky-col second-col'>"+ datatiet[j].tiet + "</td>"
				                    +cotrong
				                    +"</tr>";

					            }
				  			}

				        }
				        $("tbody#phanthantabletruongsang").append(noidungbang);

				        var tbodycotrong = document.querySelectorAll('#tablexemtkbtruongsang tbody tr td.classorongtruong');

				        for(let i=0;i<dsbuoithu.length;i++){
				        	var demtiet = dsbuoithu[i].dstiet.length;
				        	for(let j=0;j<demtiet;j++){
				        		var demlop = dsbuoithu[i].dstiet[j].dslop.length;
				        		for(let k=0;k<demlop;k++){
				        			for(let m=0;m<tbodycotrong.length;m++){
				        				var mabuoithu =tbodycotrong[m].dataset.mabuoithu; 
				        				var matiet = tbodycotrong[m].dataset.matiet;
				        				var malop = tbodycotrong[m].dataset.malop;
				        				if(dsbuoithu[i].mabuoithu == mabuoithu && dsbuoithu[i].dstiet[j].tiet == matiet && dsbuoithu[i].dstiet[j].dslop[k].malop == malop){
				        					var magiaovien = dsbuoithu[i].dstiet[j].dslop[k].dsmonhoc[0].dsgiaovien[0].magiaovien;
				        					tbodycotrong[m].innerHTML = "<span data-magiaovien="+magiaovien+" style='white-space: nowrap;'>"+dsbuoithu[i].dstiet[j].dslop[k].dsmonhoc[0].tenmonhoc+' ('+dsbuoithu[i].dstiet[j].dslop[k].dsmonhoc[0].dsgiaovien[0].bidanh+')'+"</span>";
				        				}
				        			}
				        		}
				        	}
				        }

				        // for(var i=0;i<tbodycotrong.length;i++){
				        // 	if(tbodycotrong[i].innerHTML == ''){
				        // 		tbodycotrong[i].innerHTML = "<span style='color:orange; white-space: nowrap;'>Nghỉ</span>";
				        // 	}
				        // }		
					}
				}
			}
			
		});
	});
}

//chiều
function loadthoikhoabieutruongchieu(matruong){
	$('#phandautabletruongchieu').empty();
	$('#phanthantabletruongchieu').empty();
	var idtruong = matruong;
	axios.get('getthoikhoabieutruong').then(function (response) {
		var datatkb = response.data;
		axios.get('getdsloptruong').then(function (response1) {
			var dataloptruong = response1.data;
			for(let i =0;i<datatkb.length;i++){
				for(let j = 0; j<dataloptruong.length;j++){
					if(datatkb[i].matruong == idtruong && dataloptruong[j].matruong == idtruong){
						var datalop = dataloptruong[j].dslop;

						var phandautabletruongchieu = document.getElementById("phandautabletruongchieu");
						var phanthantabletruongchieu = document.getElementById("phanthantabletruongchieu");

						var ththu = document.createElement("th");
						ththu.setAttribute("class","stickyThu");
						ththu.appendChild(document.createTextNode('Thứ'));
						phandautabletruongchieu.appendChild(ththu);

						var thtiet = document.createElement("th");
						thtiet.setAttribute("class","stickyTiet");
						thtiet.appendChild(document.createTextNode('Tiết'));
						phandautabletruongchieu.appendChild(thtiet);

						for(var k=0;k<datalop.length;k++){
							var th = document.createElement("th");
							var tenlop = document.createTextNode(' ' + datalop[k].tenlop);
						    th.setAttribute("id",+datalop[k].malop);
						    th.setAttribute("class","classlop")
						    th.appendChild(tenlop);
						    phandautabletruongchieu.appendChild(th);
						}

						var dsbuoithu = datatkb[i].dsbuoithu;

						var noidungbang = "";
				  		// var databuoithu = [
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":2,
				  		// 		"mabuoithu":"0,2",
				  		// 		"tenbuoithu":"Sáng thứ 2"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":3,
				  		// 		"mabuoithu":"0,3",
				  		// 		"tenbuoithu":"Sáng thứ 3"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":4,
				  		// 		"mabuoithu":"0,4",
				  		// 		"tenbuoithu":"Sáng thứ 4"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":5,
				  		// 		"mabuoithu":"0,5",
				  		// 		"tenbuoithu":"Sáng thứ 5"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":6,
				  		// 		"mabuoithu":"0,6",
				  		// 		"tenbuoithu":"Sáng thứ 6"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":0,
				  		// 		"mathu":7,
				  		// 		"mabuoithu":"0,7",
				  		// 		"tenbuoithu":"Sáng thứ 7"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":2,
				  		// 		"mabuoithu":"1,2",
				  		// 		"tenbuoithu":"Chiều thứ 2"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":3,
				  		// 		"mabuoithu":"1,3",
				  		// 		"tenbuoithu":"Chiều thứ 3"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":4,
				  		// 		"mabuoithu":"1,4",
				  		// 		"tenbuoithu":"Chiều thứ 4"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":5,
				  		// 		"mabuoithu":"1,5",
				  		// 		"tenbuoithu":"Chiều thứ 5"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":6,
				  		// 		"mabuoithu":"1,6",
				  		// 		"tenbuoithu":"Chiều thứ 6"
				  		// 	},
				  		// 	{
				  		// 		"mabuoi":1,
				  		// 		"mathu":7,
				  		// 		"mabuoithu":"1,7",
				  		// 		"tenbuoithu":"Chiều thứ 7"
				  		// 	},
				  		// ];
				  		var databuoithu = [
				  			{
				  				"mabuoi":0,
				  				"mathu":2,
				  				"mabuoithu":"0,2",
				  				"tenbuoithu":"Sáng thứ 2"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":2,
				  				"mabuoithu":"1,2",
				  				"tenbuoithu":"Chiều thứ 2"
				  			},
				  			{
				  				"mabuoi":0,
				  				"mathu":3,
				  				"mabuoithu":"0,3",
				  				"tenbuoithu":"Sáng thứ 3"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":3,
				  				"mabuoithu":"1,3",
				  				"tenbuoithu":"Chiều thứ 3"
				  			},
				  			{
				  				"mabuoi":0,
				  				"mathu":4,
				  				"mabuoithu":"0,4",
				  				"tenbuoithu":"Sáng thứ 4"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":4,
				  				"mabuoithu":"1,4",
				  				"tenbuoithu":"Chiều thứ 4"
				  			},
				  			{
				  				"mabuoi":0,
				  				"mathu":5,
				  				"mabuoithu":"0,5",
				  				"tenbuoithu":"Sáng thứ 5"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":5,
				  				"mabuoithu":"1,5",
				  				"tenbuoithu":"Chiều thứ 5"
				  			},
				  			{
				  				"mabuoi":0,
				  				"mathu":6,
				  				"mabuoithu":"0,6",
				  				"tenbuoithu":"Sáng thứ 6"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":6,
				  				"mabuoithu":"1,6",
				  				"tenbuoithu":"Chiều thứ 6"
				  			},
				  			{
				  				"mabuoi":0,
				  				"mathu":7,
				  				"mabuoithu":"0,7",
				  				"tenbuoithu":"Sáng thứ 7"
				  			},
				  			{
				  				"mabuoi":1,
				  				"mathu":7,
				  				"mabuoithu":"1,7",
				  				"tenbuoithu":"Chiều thứ 7"
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
				  		for (let i = 0; i < databuoithu.length; i++) {
				  			if(databuoithu[i].mabuoi == 1){
				  				var rowspan = 0;
					            var demdatatiet = datatiet.length;
					            rowspan += demdatatiet;
					            noidungbang += "<tr><td class='sticky-col first-col' style='color: red;' rowspan=" + parseInt(1 + rowspan) + ">" + databuoithu[i].tenbuoithu + "</td></tr>";
					            for (let j = 0; j < demdatatiet; j++) {

								  	var cotrong = '';
								  	var theadlop = document.querySelectorAll('#tablexemtkbtruong thead tr .classlop');
			                    	for(let x=0;x<theadlop.length;x++){
			                    		var idlop = theadlop[x].id;
							            cotrong += "<td rowspan=" + 1 + " data-mabuoithu = "+databuoithu[i].mabuoithu+" data-matiet="+datatiet[j].tiet+" data-malop="+idlop+" class='classorongtruong'></td>";
								  	}
	  		                    	
				                    noidungbang += "<tr>"
				                    +"<td class='sticky-col second-col'>"+ datatiet[j].tiet + "</td>"
				                    +cotrong
				                    +"</tr>";

					            }
				  			}
				            
				        }
				        $("tbody#phanthantabletruongchieu").append(noidungbang);

				        var tbodycotrong = document.querySelectorAll('#tablexemtkbtruongchieu tbody tr td.classorongtruong');

				        for(let i=0;i<dsbuoithu.length;i++){
				        	var demtiet = dsbuoithu[i].dstiet.length;
				        	for(let j=0;j<demtiet;j++){
				        		var demlop = dsbuoithu[i].dstiet[j].dslop.length;
				        		for(let k=0;k<demlop;k++){
				        			for(let m=0;m<tbodycotrong.length;m++){
				        				var mabuoithu =tbodycotrong[m].dataset.mabuoithu; 
				        				var matiet = tbodycotrong[m].dataset.matiet;
				        				var malop = tbodycotrong[m].dataset.malop;
				        				if(dsbuoithu[i].mabuoithu == mabuoithu && dsbuoithu[i].dstiet[j].tiet == matiet && dsbuoithu[i].dstiet[j].dslop[k].malop == malop){
				        					var magiaovien = dsbuoithu[i].dstiet[j].dslop[k].dsmonhoc[0].dsgiaovien[0].magiaovien;
				        					tbodycotrong[m].innerHTML = "<span data-magiaovien="+magiaovien+" style='white-space: nowrap;'>"+dsbuoithu[i].dstiet[j].dslop[k].dsmonhoc[0].tenmonhoc+' ('+dsbuoithu[i].dstiet[j].dslop[k].dsmonhoc[0].dsgiaovien[0].bidanh+')'+"</span>";
				        				}
				        			}
				        		}
				        	}
				        }

				        // for(var i=0;i<tbodycotrong.length;i++){
				        // 	if(tbodycotrong[i].innerHTML == ''){
				        // 		tbodycotrong[i].innerHTML = "<span style='color:orange; white-space: nowrap;'>Nghỉ</span>";
				        // 	}
				        // }		
					}
				}
			}
			
		});
	});
}

function loaddanhsachgv(datadsgv) {
	var datadsgv = datadsgv;
	var selectListGv = document.getElementById('idselectgv');
	$('#idselectgv').append("<option value='none' selected='' disabled=''></option>");
	for(var i= 0; i< datadsgv.length;i++){
		var option = document.createElement("option");
	    option.value = datadsgv[i].id;
	    option.text = datadsgv[i].hovaten;
	    selectListGv.appendChild(option);
	}
	$('#idselectgv').select2({ width: '50%'});

	$('#idselectgv').on('change',function(){
  		var sel = document.getElementById("idselectgv");
		var text= sel.options[sel.selectedIndex].text;
		var idgv = sel.options[sel.selectedIndex].value;
		var idtruonggv = $('#idtruonggv').val();
  		$('#idtengv').text(text);

		$('#phanthantablegiaovien').empty();
  		axios.get('getthoikhoabieugv').then(function (response) {
			var datatkbgv = response.data;
			for(let i =0;i<datatkbgv.length;i++){
				var demdsgv = datatkbgv[i].dsgiaovien.length;
				for(let j=0;j<demdsgv;j++){ 
					if(datatkbgv[i].matruong == idtruonggv && datatkbgv[i].dsgiaovien[j].magiaovien == idgv){

						var phanthantablegiaovien = document.getElementById("phanthantablegiaovien");

						var dsbuoi = datatkbgv[i].dsgiaovien[j].dsbuoi;

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
							  	var theadthu = document.querySelectorAll('#tablexemtkbgiaovien thead tr .classthu');
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
				        $("tbody#phanthantablegiaovien").append(noidungbang);

				        var tbodycotrong = document.querySelectorAll('#tablexemtkbgiaovien tbody tr td.classoronggiaovien');

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
				        // for(var i=0;i<tbodycotrong.length;i++){
				        // 	if(tbodycotrong[i].innerHTML == ''){
				        // 		tbodycotrong[i].innerHTML = "<span style='color:orange; white-space: nowrap;'>Nghỉ</span>";
				        // 	}
				        // }		
					}
				}
				
			}	
				
		});

		var tbodygv = $("#tablexemtkbgiaovien tbody#phanthantablegiaovien");
		if(tbodygv.children().length == 0){
			document.getElementById("cardxeptkbgiaovien").style.display = "none";
		}
  		
  	});

}

function loaddanhsachkhoilop(datadskhoi,datadslop){
	var datadskhoi = datadskhoi;
	var datadslop = datadslop;
	var selectListKhoi = document.getElementById('idselectkhoi');
	var selectListLop = document.getElementById('idselectlop');
	$('#idselectkhoi').append("<option value='none' selected='' disabled=''</option>");
	for(var i= 0; i< datadskhoi.length;i++){
		var option = document.createElement("option");
	    // option.value = datadskhoi[i].id;
	    option.value = datadskhoi[i].tenkhoi;
	    option.text = datadskhoi[i].tenkhoi;
	    selectListKhoi.appendChild(option);
	}

	$('#idselectkhoi').on('change',function(){
		document.getElementById("cardxeptkblop").style.display = "none";
		$('#idselectlop').find('option').remove();
		$('#idselectlop').append("<option value='none' selected='' disabled=''></option>");
		var datakhoi = $(this).val();
		for(var j=0;j<datadslop.length;j++){
			if(datadslop[j].khoi == datakhoi){
				var optionLop = document.createElement("option");
				optionLop.value = datadslop[j].id;
				optionLop.text = datadslop[j].tenlop;
				selectListLop.appendChild(optionLop);
			}
		}
	});
	$('#idselectkhoi').select2({ width: '50%'});
	$('#idselectlop').select2({ width: '50%'});

	$('#idselectlop').on('change',function(){
  		var sel = document.getElementById("idselectlop");
		var text= sel.options[sel.selectedIndex].text;
		var idlop = sel.options[sel.selectedIndex].value;
		var idtruonglop = $('#idtruonglop').val();
  		$('#idtenlop').text(text);

  		$('#phanthantablelop').empty();
  		axios.get('getthoikhoabieulop').then(function (response) {
			var datatkblop = response.data;
			for(let i =0;i<datatkblop.length;i++){
				var demdslop = datatkblop[i].dslop.length;
				for(let j=0;j<demdslop;j++){ 
					if(datatkblop[i].matruong == idtruonglop && datatkblop[i].dslop[j].malop == idlop){

						var phanthantablelop = document.getElementById("phanthantablelop");

						var dsbuoi = datatkblop[i].dslop[j].dsbuoi;

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
							  	var theadthu = document.querySelectorAll('#tablexemtkblop thead tr .classthu');
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
				        $("tbody#phanthantablelop").append(noidungbang);

				        var tbodycotrong = document.querySelectorAll('#tablexemtkblop tbody tr td.classoronglop');

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
				        // for(var i=0;i<tbodycotrong.length;i++){
				        // 	if(tbodycotrong[i].innerHTML == ''){
				        // 		tbodycotrong[i].innerHTML = "<span style='color:orange; white-space: nowrap;'>Nghỉ</span>";
				        // 	}
				        // }		
					}
				}
				
			}	
				
		});

		var tbodylop = $("#tablexemtkblop tbody#phanthantablelop");
		if(tbodylop.children().length == 0){
			document.getElementById("cardxeptkblop").style.display = "none";
		}
  		
  	});

}


function loadbanggiaovien(matruong){
	$('#banggiaovien').empty();
	var idtruong = matruong;
	axios.get('getdstruong').then(function (response) {
		var data = response.data;
		for(var i=0;i<data.length;i++){
			if(idtruong == data[i].matruong){
				var dsgv = data[i].danhsachgv;
				var banggiaovien  = document.getElementById("banggiaovien");
				var demdsgv = dsgv.length;

		        for (var j = 0; j < demdsgv; j++) {
		            tr = document.createElement("tr");
		            tr.appendChild(document.createElement('td'));
			        tr.appendChild(document.createElement('td'));
			        tr.appendChild(document.createElement('td'));

			        var randomColor = '#'+ ('000000' + Math.floor(Math.random()*16777215).toString(16)).slice(-6);

			        var button = document.createElement("button");
			        button.style.backgroundColor = randomColor;
			        button.type = "button";
			        button.style.width = "20px";
			        button.style.height = "20px";
			        button.setAttribute("data-magiaovien",dsgv[j].id);
			        button.setAttribute("class","classbuttonmau");

			        button.onclick = function(e) {
						$('#tablemaugiaovien tbody tr').removeClass('active');
        				$(this).parent().parent().addClass('active');
        				xulythemmau(); 		
		            };

		        	tr.cells[0].appendChild(document.createTextNode('' +(j+1)));
			        tr.cells[1].appendChild(document.createTextNode(' ' + dsgv[j].bidanh));
			       	tr.cells[2].appendChild(button); 

			        banggiaovien.appendChild(tr); 
		        }

			}
		}
	});

	
	
}
function xulythemmau(){
	var tbodybangmauchon = document.querySelectorAll('#tablemaugiaovien tbody tr.active td button.classbuttonmau');
	//sáng và chiều
	var tbodycotrongtruong = document.querySelectorAll('#tablexemtkbtruong tbody tr td.classorongtruong span');
	var buttonmagiaovien = tbodybangmauchon[0].dataset.magiaovien;
	var laymau = tbodybangmauchon[0].style['background-color'];
	for(var i =0;i<tbodycotrongtruong.length;i++){
	var magiaovien =tbodycotrongtruong[i].dataset.magiaovien; 
		if(magiaovien == buttonmagiaovien){
			tbodycotrongtruong[i].style.backgroundColor = laymau;
			tbodycotrongtruong[i].style.color = "white";
		}else{
			tbodycotrongtruong[i].style.backgroundColor = '';
			tbodycotrongtruong[i].style.color = '';
		}
	}
	//sáng
	var tbodycotrongtruongsang = document.querySelectorAll('#tablexemtkbtruongsang tbody tr td.classorongtruong span');
	var buttonmagiaovien = tbodybangmauchon[0].dataset.magiaovien;
	var laymau = tbodybangmauchon[0].style['background-color'];
	for(var j =0;j<tbodycotrongtruongsang.length;j++){
	var magiaovien =tbodycotrongtruongsang[j].dataset.magiaovien; 
		if(magiaovien == buttonmagiaovien){
			tbodycotrongtruongsang[j].style.backgroundColor = laymau;
			tbodycotrongtruongsang[j].style.color = "white";
		}else{
			tbodycotrongtruongsang[j].style.backgroundColor = '';
			tbodycotrongtruongsang[j].style.color = '';
		}
	}
	//chiều
	var tbodycotrongtruongchieu = document.querySelectorAll('#tablexemtkbtruongchieu tbody tr td.classorongtruong span');
	var buttonmagiaovien = tbodybangmauchon[0].dataset.magiaovien;
	var laymau = tbodybangmauchon[0].style['background-color'];
	for(var k =0;k<tbodycotrongtruongchieu.length;k++){
	var magiaovien =tbodycotrongtruongchieu[k].dataset.magiaovien; 
		if(magiaovien == buttonmagiaovien){
			tbodycotrongtruongchieu[k].style.backgroundColor = laymau;
			tbodycotrongtruongchieu[k].style.color = "white";
		}else{
			tbodycotrongtruongchieu[k].style.backgroundColor = '';
			tbodycotrongtruongchieu[k].style.color = '';
		}
	}

}

window.onload = function() {

	loaddanhsachtruong();
	$("#bangdstruong").on('show.bs.collapse', function(){
    	document.getElementById("formxemtkb").style.display = "none";
    	$('#idselectgv').find('option').remove();
    	$('#idselectlop').find('option').remove();
    	$('#idselectkhoi').find('option').remove();
    	$('#xemtkbtruong').prop('checked', false);
  		$('#xemtkbgiaovien').prop('checked', false);
  		$('#xemtkblop').prop('checked', false);
  		$('.httkbs').prop('checked', false);
  		$('.httkbc').prop('checked', false);
  		$('.httkbsc').prop('checked', false);
  		document.getElementById("cardmaugiaovien").style.display = "none";
  		document.getElementById("cardxeptkbgiaovien").style.display = "none";
  		document.getElementById("cardxeptkblop").style.display = "none";
  		document.getElementById("cardselectgv").style.display = "none";
  		document.getElementById("cardselectlop").style.display = "none";
  	});
  		
	// $('#phongtothunhotkbtruong').on('click',function(){
	// 	var tablesc = document.getElementById("tablexemtkbtruong");
	// 	if(!$("#cardxeptkbtruong").hasClass("card card-fullscreen")) 
	// 	{   
	//         tablesc.style.height = "50%";
	// 	}else{
	// 		tablesc.style.height = "600px";
	// 	}
	// });

  // 	$('#idselectgv').on('change',function(){
  // 		var sel = document.getElementById("idselectgv");
		// var text= sel.options[sel.selectedIndex].text;
  // 		$('#idtengv').text(text);
  // 		document.getElementById("cardxeptkbgiaovien").style.display = "block";
  // 	});

  // 	$('#idselectlop').on('change',function(){
  // 		var sel = document.getElementById("idselectlop");
		// var text= sel.options[sel.selectedIndex].text;
  // 		$('#idtenlop').text(text);
  // 		document.getElementById("cardxeptkblop").style.display = "block";
  // 	});

 //  	function toggleFullscreen(elem) {
	//   	elem = elem || document.documentElement;
	//   	if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
	// 	    if (elem.requestFullscreen) {
	// 	      	elem.requestFullscreen();
	// 	    } else if (elem.msRequestFullscreen) {
	// 	      	elem.msRequestFullscreen();
	// 	    } else if (elem.mozRequestFullScreen) {
	// 	      	elem.mozRequestFullScreen();
	// 	    } else if (elem.webkitRequestFullscreen) {
	// 	      	elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
	// 	    }
	// 	} else {
	// 	    if (document.exitFullscreen) {
	// 	      	document.exitFullscreen();
	// 	    } else if (document.msExitFullscreen) {
	// 	      	document.msExitFullscreen();
	// 	    } else if (document.mozCancelFullScreen) {
	// 	      	document.mozCancelFullScreen();
	// 	    } else if (document.webkitExitFullscreen) {
	// 	      	document.webkitExitFullscreen();
	// 	    }
	// 	}
	// }

	$("input[type='checkbox']").change(function () {
		//sáng
		if($(".httkbs").prop("checked")){
			var tbodysang = $("#tablexemtkbtruongsang tbody#phanthantabletruongsang");
			if(tbodysang.children().length == 0){
				document.getElementById("bangsang").style.display = "none";
			}else{
				document.getElementById("bangsang").style.display = "block";
				// toggleFullscreen();
			}			
		}else{
			document.getElementById("bangsang").style.display = "none";
		}

		//chiều
		if($(".httkbc").prop("checked")){
			var tbodychieu = $("#tablexemtkbtruongchieu tbody#phanthantabletruongchieu");
			if(tbodychieu.children().length == 0){
				document.getElementById("bangchieu").style.display = "none";
			}else{
				document.getElementById("bangchieu").style.display = "block";
				// toggleFullscreen();
			}
		}else{
			document.getElementById("bangchieu").style.display = "none";
		}

		//sáng và chiều
		if($(".httkbsc").prop("checked")){
			var tbodysangchieu = $("#tablexemtkbtruong tbody#phanthantabletruong");
			if(tbodysangchieu.children().length == 0){
				document.getElementById("bangsangchieu").style.display = "none";
			}else{
				document.getElementById("bangsangchieu").style.display = "block";
				// toggleFullscreen();
			}
		}else{
			document.getElementById("bangsangchieu").style.display = "none";
		}
  	});


  	$(document).on('click', 'input[type="checkbox"]', function() {      
	    $('input[type="checkbox"]').not(this).prop('checked', false);      
	});

	$("#xemtkbtruong").change(function () {
		$('#idselectgv').val('none').trigger('change.select2');
		$('#idselectkhoi').val('none').trigger('change.select2');
		$('#idselectlop').val('none').trigger('change.select2');
		var tbodymaugv = $("#tablemaugiaovien tbody#banggiaovien");
		if(tbodymaugv.children().length == 0){
			document.getElementById("cardmaugiaovien").style.display = "none";
		}else{
			document.getElementById("cardmaugiaovien").style.display = "block";
		}
		
	});

	$("#xemtkblop").change(function () {

		$('#idselectgv').val('none').trigger('change.select2');
	});

	$("#xemtkbgiaovien").change(function () {

		$('#idselectkhoi').val('none').trigger('change.select2');
		$('#idselectlop').val('none').trigger('change.select2');
	});
}
