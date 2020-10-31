function loadthongkesoluongtietday() {
	axios.get('getdsgvpcgd').then(function (response) {
		var data = response.data;
		var data1 = [];
		data.filter(function(items){
			var data2 = [];
			var datagv = items.danhsachgv;
			var matruong = items.matruong;
			data1.push({
				matruong: items.matruong,
				tentruong: items.tentruong,
				mahuyen: items.mahuyen,
				caphoc: items.caphoc,
				loaitruong: items.loaitruong,
				danhsachgv: data2,
				phonghoc: items.phonghoc

			});
			datagv.filter(function(items1,label){
				var stt = label + 1;
				if(matruong == items1.matruong){
					var data3 = [];
					var datamonhoc = items1.monhoc;
					var magv = items1.id;
					data2.push({
						stt: stt.toString(),
						id: items1.id,
						hovaten: items1.hovaten,
						bidanh: items1.bidanh,
						monhoc: data3
					});
					datamonhoc.filter(function(items2){
						if(magv == items2.magiaovien){
							var data4= [];
							var malop = items2.malop;
							var sotiet = items2.sotiet;
							var datalop = items2.danhsachlophoc;
							var mamonhoc = items2.mamonhoc;
							data3.push({
								id: items2.id,
								tenmonhoc: items2.tenmonhoc,
								danhsachlophoc: data4,
								magiaovien: magv

							});
							if(malop == datalop.id){
								data4.push({
									id: datalop.id,
									tenlop: datalop.tenlop,
									sotiet: sotiet,
									mamonhoc: mamonhoc
								});
							}
						}
					});
				}
			});
		});

		var selectListTruong = document.getElementById('idselecttruong');
		$('#idselecttruong').append("<option></option>");
		for(var i= 0; i< data1.length;i++){
			var option = document.createElement("option");
		    option.value = data1[i].matruong;
		    option.text = data1[i].tentruong;
		    selectListTruong.appendChild(option);
		}


		$('#idselecttruong').on('change',function(){
			var table = $('#tablesotietday').DataTable();
			table.destroy();
			$('#tablesotietday>tbody').empty();
			$('#tablesophonghoc>tbody').empty();
			$('#idtentruong').text('');
			$('#idtentruongphonghoc').text('');
			var datatruong = $(this).val();
			for(var j=0;j<data1.length;j++){
				if(data1[j].matruong == datatruong){
					$("#idtentruong").text(data1[j].tentruong);
					$("#idtentruongphonghoc").text(data1[j].tentruong);
					$("#idtentruonggiaovien").text(data1[j].tentruong);
					var phanthantablesotietday = document.getElementById("phanthantablesotietday");
					var phanthantablesophonghoc = document.getElementById("phanthantablesophonghoc");
					var phanthantablesogiaovien = document.getElementById("phanthantablesogiaovien");
					var datagv = data1[j].danhsachgv;
					var countdatagv = datagv.length;
					for (var k = 0; k < countdatagv; k++) {

						tr = document.createElement("tr");
			            tr.appendChild(document.createElement('td'));
				        tr.appendChild(document.createElement('td'));
				        tr.appendChild(document.createElement('td'));
				        tr.appendChild(document.createElement('td'));

				        var item = datagv[k].monhoc;
						var groups = {};
						for (var i = 0; i < item.length; i++) {
							// console.log(tenmonhoc);
							var magiaovien = item[i].magiaovien;
							var tenmonhoc = item[i].tenmonhoc;
							if (!groups[tenmonhoc]) {
								groups[tenmonhoc] = [];
							}
							groups[tenmonhoc].push(item[i].danhsachlophoc);
						}
						var magv = magiaovien;
						var data_new = [];
						for (var tenmonhoc in groups ) {
							// console.log(idmonhoc);
							data_new.push({tenmonhoc: tenmonhoc,magiaovien: magv ,danhsachlophoc: groups[tenmonhoc]});

						};
						// console.log(data_new);
						var div =  document.createElement("div");
						div.setAttribute("id","iddiv");
						// var arrmonlop = [];
						var tongtietgvmonlop = 0;
						var temp = data_new.map(function(value) {
							var item1 = value.danhsachlophoc;
							var arrmonlop = [];
							// console.log(item1);
							var tongtietmonlop = 0;
							var temp1 = item1.map(function(value1){
								var find = item1.findIndex((x) => x.mamonhoc == value1[0].mamonhoc);
						        if (find == -1) {
						        	tongtietmonlop += value1[0].sotiet;
						        }
								return value1[0].tenlop+": "+value1[0].sotiet;

								
							}).join(", ");							
							var closeSpan = document.createElement("span");
							closeSpan.textContent = value.tenmonhoc+": "+tongtietmonlop+" ("+temp1+")";
							// var div =  document.createElement("div");
							div.appendChild(closeSpan);
							arrmonlop.push([{magiaovien: value.magiaovien, tongtietmonlop: tongtietmonlop}]);
							arrmonlop.map(function(value2){
								// console.log(value2);
								var findmgv = arrmonlop.findIndex((x) => x.magiaovien == value2[0].magiaovien);
						        if (findmgv == -1) {
						        	tongtietgvmonlop += value2[0].tongtietmonlop;
						        }
							});		
						});
	
			        	tr.cells[0].appendChild(document.createTextNode(' ' + datagv[k].stt));
				        tr.cells[1].appendChild(document.createTextNode(' ' + datagv[k].hovaten));
				       	tr.cells[2].appendChild(document.createTextNode(' ' + tongtietgvmonlop));
				       	tr.cells[2].setAttribute("style","color:red;"); 
				        tr.cells[3].appendChild(div);
				        phanthantablesotietday.appendChild(tr);
					}

					//thống kế sl phòng học
					var demslphong = data1[j].phonghoc.length;
					var dataphong = data1[j].phonghoc;
					var dataphongdemslphong = [];
					var dulieuphong = [];
					dataphong.filter(function(items,label){						
						var timphong = dulieuphong.findIndex((x) => x.matruong == items.matruong);
						if (timphong == -1) {
						    dulieuphong.push({id:items.id,tenphong:items.tenphong});
						}
					});
					dataphongdemslphong.push({stt:1,demslphong:demslphong,dulieuphong:dulieuphong});
					var countdatapdslp = dataphongdemslphong.length;
					for (var m = 0; m < countdatapdslp; m++) {

						tr = document.createElement("tr");
			            tr.appendChild(document.createElement('td'));
				        tr.appendChild(document.createElement('td'));
				        tr.appendChild(document.createElement('td'));

				        var item = dataphongdemslphong[m].dulieuphong;

						var temp = item.map(function(value) {
							return value.tenphong;	
						}).join(", ");
	
			        	tr.cells[0].appendChild(document.createTextNode(' ' + dataphongdemslphong[m].stt));
				       	tr.cells[1].appendChild(document.createTextNode(' ' + dataphongdemslphong[m].demslphong));
				       	tr.cells[1].setAttribute("style","color:red;"); 
				        tr.cells[2].appendChild(document.createTextNode(' ' + temp));
				        phanthantablesophonghoc.appendChild(tr);
					}

					//thống kê sl giáo viên
					var demslgv= data1[j].danhsachgv.length;
					var dsgv = data1[j].danhsachgv;
					for (var z = 0; z < 1; z++) {

						tr = document.createElement("tr");
			            tr.appendChild(document.createElement('td'));
				        tr.appendChild(document.createElement('td'));
						
				        var x = document.createElement("BUTTON");
				        x.setAttribute("type", "button");
				        x.setAttribute("style","color:red;"); 
						var t = document.createTextNode(""+ demslgv);
						x.onclick = function(e){
							loaddanhsachgv(dsgv);
							$('#modaldsgv').modal('show');
						};
						// t.setAttribute("style","color:red;"); 
						x.appendChild(t);

			        	tr.cells[0].appendChild(document.createTextNode(' ' + (z+1)));
				       	tr.cells[1].appendChild(x);
				       	// tr.cells[1].setAttribute("style","color:red;"); 
				        phanthantablesogiaovien.appendChild(tr);
					}

				}
			$("#iddiv span").after("<br />");

			}
			$('#tablesotietday').DataTable({
				"oLanguage": {
				  	"sProcessing":   "Đang xử lý...",
					"sLengthMenu":   "Xem _MENU_ mục",
					"sZeroRecords":  "Không tìm thấy dòng nào phù hợp",
					"sInfo":         "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
					"sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 mục",
					"sInfoFiltered": "(được lọc từ _MAX_ mục)",
					"sInfoPostFix":  "",
					"sSearch":       "Tìm:",
					"sUrl":          "",
					"oPaginate": {
						"sFirst":    "Đầu",
						"sPrevious": "Trước",
						"sNext":     "Tiếp",
						"sLast":     "Cuối"
					}
				}	
			});		
			// $("#iddiv span").after("<br />");
		});

	});
}
function loaddanhsachgv(dsgv){
	var dsgv = dsgv;
	var phanthantablegv = document.getElementById("phanthantablegv");
	for (var i = 0; i < dsgv.length; i++) {
		tr = document.createElement("tr");
        tr.appendChild(document.createElement('td'));
        tr.appendChild(document.createElement('td'));
		
    	tr.cells[0].appendChild(document.createTextNode(' ' + dsgv[i].stt));
       	tr.cells[1].appendChild(document.createTextNode(' ' + dsgv[i].hovaten));
       	// tr.cells[1].setAttribute("style","color:red;"); 
        phanthantablegv.appendChild(tr);
	}
}
jQuery(document).ready(function () {
    jQuery('#modaldsgv').on('hidden.bs.modal', function (e) {
		$('#tablegv>tbody').empty();
    });
});
window.onload = function() {
	loadthongkesoluongtietday();
	$('#idselecttruong').select2({ width: '50%'});
	$('#idselectgiaovien').select2({ width: '50%'});
	$('#tablesotietday').DataTable({
		"oLanguage": {
		  	"sProcessing":   "Đang xử lý...",
			"sLengthMenu":   "Xem _MENU_ mục",
			"sZeroRecords":  "Không tìm thấy dòng nào phù hợp",
			"sInfo":         "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
			"sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 mục",
			"sInfoFiltered": "(được lọc từ _MAX_ mục)",
			"sInfoPostFix":  "",
			"sSearch":       "Tìm:",
			"sUrl":          "",
			"oPaginate": {
				"sFirst":    "Đầu",
				"sPrevious": "Trước",
				"sNext":     "Tiếp",
				"sLast":     "Cuối"
			}
		}	
	});

};