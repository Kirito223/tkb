    setTimeout(function() {
    	loadchonlopsang(); 
    	loadchonlopchieu();    
    },100);



    function rangbuoctiettranh(){
    	var data = axios.get('getlistrangbuoctiettranh').then(function(response) {
    		var data1 = response.data[0].monhoc;
    		var data2 = response.data[0].rangbuoctiettranh;
    		var data3 = response.data[0].rangbuocchontiet;
    		var datas = data1.map(function(value, label) {
    			let data = value;
    			let stt = label + 1;
    			var datas = Object.assign(data, {
    				stt: stt.toString()
    			});
    			return datas;
    		});
    		$("#girdrangbuoctiettranh").dxDataGrid({
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
    			filterRow: {
    				visible: true,
    				applyFilter: "auto"
    			},
    			searchPanel: {
    				visible: true,
    				width: 240,
    				placeholder: "Tìm kiếm..."
    			},
    			pager: {
    				showPageSizeSelector: true,
    				allowedPageSizes: [10, 30,50],
    				showInfo: true
    			},
    			/* co dan cot */
    			allowColumnResizing: true,
    			columnResizingMode: "widget",
    			columns: [{
    				caption: "STT",
    				dataField: "stt",
    				width: 50,
    				allowEditing: false,
    			}, {
    				caption: "Môn học",
    				dataField: "tenmonhoc",
    				width: 120,
    			}, {
    				caption: "Tiết không được xếp",
    				cellTemplate: function (container, options) {
    					var mon = options.data.id;			
    					var rangbuoc = data3;
    					var tietkodkxep = [];
    					var loctiet = [];
    					var lucky = rangbuoc.filter(function(items){
						// var i = loctiet.findIndex(x => x == items.tiet);
						// if (i <= -1) {
							if(mon == items.mamonhoc ){
								if(items.buoi == 0){
									var text = 'Tiết '+ items.tiet + '- Buổi sáng(Mức '+items.mucrangbuoc+') <br>';
									loctiet.push(items.tiet);
									tietkodkxep.push(text);
								}else if(items.buoi == 1){
									var text = 'Tiết '+ items.tiet + '- Buổi chiều(Mức '+items.mucrangbuoc+') <br>';
									loctiet.push(items.tiet);
									tietkodkxep.push(text);
								}
							}
						// }
					});
    					$("<div>").html(tietkodkxep).appendTo(container);
    				}
    			},{
    				caption: "Chọn tiết",
    				cellTemplate: function (container, options) {
    					$("<div>").dxButton({
    						stylingMode: "contained",
    						text: "Chọn tiết",
    						type: "default",
    						width: 100,
    						onClick: function() {							
    							var idmon = options.data;
    							datachontietmon = idmon.id;
    							var datarb = data3;
    							$('#tiettranhcuamon').html('<h4 class="modal-title">Chọn tiết tránh của môn: '+ idmon.tenmonhoc +'</h4>');
    							$("#chontiet").modal('show');
    							chontiet(idmon,datarb);
    						}
    					}).appendTo(container);
    				},
    				width:100,
    			},{
    				caption: "Chỉ học buổi sáng",
    				cellTemplate: function (container, options) {
    					var mon = options.data.id;	
    					datachonlops = mon;		
    					var rangbuoc = data2;
    					var lopsang = [];
    					var loclops = [];
    					var lucky = rangbuoc.filter(function(items){
    						var i = loclops.findIndex(x => x == items.malop);
    						if (i <= -1) {
    							if(mon == items.mamonhoc ){
    								if(items.buoi == 0){
    									var text = items.tenlop ;
    									loclops.push(items.malop);
    									lopsang.push(text);
    								}
    							}
    						}
    					});

    					var aa = $("<div class='col-md-7' style='height: 30px;'>").html('Lớp: '+ lopsang).appendTo(container);
    					var bb = $("<div class='col-md-5'>").dxButton({
    						stylingMode: "contained",
    						text: "Chọn lớp",
    						type: "default",
    						width: 100,
    						onClick: function() {							
    							var idmon = options.data;
    							datachonlops = idmon.id;		
    							$('#lopstranhcuamon').html('<h4 class="modal-title">Chọn lớp áp dụng chỉ học buổi sáng cho môn: '+ idmon.tenmonhoc +'</h4>');
    							$("#chonlopsang").modal('show');
    							checklophocsang(options.data,data2);
    						}
    					}).appendTo(container);					
    				},
    				width:180,
    			},{
    				caption: "Chỉ học buổi chiều",
    				cellTemplate: function (container, options) {
    					var mon = options.data.id;				
    					var rangbuoc = data2;
    					var lopchieu = [];
    					var loclopc = [];
    					var lucky = rangbuoc.filter(function(items){
    						var i = loclopc.findIndex(x => x == items.malop);
    						if (i <= -1) {
    							if(mon == items.mamonhoc ){
    								if(items.buoi == 1){
    									var text = items.tenlop ;
    									loclopc.push(items.malop);
    									lopchieu.push(text);
    								}
    							}
    						}
    					});

    					var aa = $("<div class='col-md-7' style='height: 30px;'>").html('Lớp: '+ lopchieu).appendTo(container);
    					var bb = $("<div class='col-md-5'>").dxButton({
    						stylingMode: "contained",
    						text: "Chọn lớp",
    						type: "default",
    						width: 100,
    						onClick: function() {							
    							var idmon = options.data;
    							datachonlopc = idmon.id;	
    							$('#lopctranhcuamon').html('<h4 class="modal-title">Chọn lớp áp dụng chỉ học buổi chiều cho môn: '+ idmon.tenmonhoc +'</h4>');
    							$("#chonlopchieu").modal('show');
    							checklophocchieu(options.data,data2);
    						}
    					}).appendTo(container);	
    				},
    				width:180,
    			},
    			],
    		});
});	
}




function chontiet(idmon,datarb){
	var datachontiet = datarb.filter(function(items){
		if(items.mamonhoc == idmon.id && items.malop == null){
			return items;
		}
	});
	var datas = [{
		'tiet':1,
		'buoi':0,
	},{
		'tiet':2,
		'buoi':0,
	},{
		'tiet':3,
		'buoi':0,
	},{
		'tiet':4,
		'buoi':0,
	},{
		'tiet':5,
		'buoi':0,
	},{
		'tiet':1,
		'buoi':1,
	},{
		'tiet':2,
		'buoi':1,
	},{
		'tiet':3,
		'buoi':1,
	},{
		'tiet':4,
		'buoi':1,
	},{
		'tiet':5,
		'buoi':1,
	}];

	$("#girdchontiet").dxDataGrid({
		dataSource: datas,
		showBorders: true,
		/* xap xep */
		sorting: {
			mode: "multiple"
		},

		// selection: {
		// 	mode: "single",
		// },
		/* co dan cot */
		allowColumnResizing: true,
		columnResizingMode: "widget",
		columns: [{
			caption: "Chọn tiết",
			cellTemplate: function (container, options) {
				var aa = $("<div>").html('<input type="checkbox" id='+options.rowIndex+' value="">').appendTo(container);	
				var loclopbuoi = [];
				var locloptiet = [];
				datachontiet.filter(function(items){ 
					// var i = loclopbuoi.findIndex(x => x == items.buoi);
					// var ii = locloptiet.findIndex(x => x == items.tiet);
					// if (i <= -1 && ii <= -1) {
						loclopbuoi.push(items.buoi);
						locloptiet.push(items.tiet);
						if(options.data.buoi == items.buoi && options.data.tiet == items.tiet){
							document.getElementById(options.rowIndex).checked = true;
						}
					// }
				});	
			},
			width:80,
		},{
			caption: "Tiết",
			cellTemplate: function (container, options) {
				var tiet = options.data.tiet;
				var buoi = options.data.buoi;
				if(tiet == 1 && buoi == 0){
					$("<div>").html('Tiết 1 - Sáng').appendTo(container);
				}else if(tiet == 2 && buoi == 0){
					$("<div>").html('Tiết 2 - Sáng').appendTo(container);
				}else if(tiet == 2 && buoi == 0){
					$("<div>").html('Tiết 2 - Sáng').appendTo(container);
				}else if(tiet == 3 && buoi == 0){
					$("<div>").html('Tiết 3 - Sáng').appendTo(container);
				}else if(tiet == 4 && buoi == 0){
					$("<div>").html('Tiết 4 - Sáng').appendTo(container);
				}else if(tiet == 5 && buoi == 0){
					$("<div>").html('Tiết 5 - Sáng').appendTo(container);
				}else if(tiet == 1 && buoi == 1){
					$("<div>").html('Tiết 1 - Chiều').appendTo(container);
				}else if(tiet == 2 && buoi == 1){
					$("<div>").html('Tiết 2 - Chiều').appendTo(container);
				}else if(tiet == 3 && buoi == 1){
					$("<div>").html('Tiết 3 - Chiều').appendTo(container);
				}else if(tiet == 4 && buoi == 1){
					$("<div>").html('Tiết 4 - Chiều').appendTo(container);
				}else if(tiet == 5 && buoi == 1){
					$("<div>").html('Tiết 5 - Chiều').appendTo(container);
				}					
			},
		},{
			caption: "Mức ràng buộc",
			cellTemplate: function (container, options) {
				$("<div>").html('<select class="form-control input-xs" id="mucrangbuoc'+options.rowIndex+'"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select>').appendTo(container);
				var loclopbuoi = [];
				var locloptiet = [];
				datachontiet.filter(function(items){ 
					// var i = loclopbuoi.findIndex(x => x == items.buoi);
					// var ii = locloptiet.findIndex(x => x == items.tiet);
					// if (i <= -1 && ii <= -1) {
						loclopbuoi.push(items.buoi);
						locloptiet.push(items.tiet);
						if(options.data.buoi == items.buoi && options.data.tiet == items.tiet){
							$('#mucrangbuoc'+options.rowIndex+'').val(items.mucrangbuoc);
						}
					// }
				});					
			},
		}],
	});
}



function loadchonlopsang(idlopsang){
	var data = axios.get('getkhoihoc').then(function(response) {
		var data1 = response.data;	
		let headTable = document.getElementById("headTable");
		let bodyTable = document.getElementById("lophocsang");
		// Tim khoi lop co nhieu lop nhat
		let max = 0;
		for (const iterator of data1) {
			if (iterator.danhsachlophoc.length > max) {
				max = iterator.danhsachlophoc.length;
			}
		}
      // Render Header truoc
      for (const iterator of data1) {
      	var chkbox = document.createElement('input');
      	chkbox.setAttribute("type", "checkbox");
      	chkbox.setAttribute("value", iterator.id);
      	chkbox.setAttribute("data-khoi", iterator.id);
      	var text = document.createTextNode(' '+iterator.tenkhoi);
      	let th = document.createElement("th");    

      	chkbox.onclick = function (e) {
      		let chkClass = document.querySelectorAll(`.classRoom[data-khoi="${e.target.dataset.khoi}"]`);
      		for (const classRoom of chkClass) {
      			classRoom.checked = e.target.checked;
      		}
      	};  	

      	th.setAttribute("data-khoi", iterator.id);
      	th.appendChild(chkbox);   
      	th.appendChild(text);     
      	headTable.appendChild(th);
      }
      // Render phan than(tbody)
      let className = [];
      // Lap theo so lop hoc lon nhat
      for (let position = 0; position < max; position++) {
      	let tr = document.createElement("tr");
      	for (const iterator of data1) {
      		let td = document.createElement("td");
      		var idlop = iterator.danhsachlophoc[position];
      		if (iterator.danhsachlophoc[position] != undefined) {
      			var chkbox = document.createElement('input');
      			chkbox.setAttribute("type", "checkbox");
      			chkbox.setAttribute("class", "classRoom");
      			chkbox.setAttribute("value", idlop.id);
      			chkbox.setAttribute("data-khoi",iterator.danhsachlophoc[position].khoi);
      			var text = document.createTextNode(' '+iterator.danhsachlophoc[position].tenlop);
      			td.appendChild(chkbox);
      			td.setAttribute("class", "lophoc");
      			td.appendChild(text);
      			tr.appendChild(td);
      		} else {
      			tr.appendChild(td);
      		}
      	}
      	bodyTable.appendChild(tr);
      }
  });
}


function loadchonlopchieu(idlopchieu){
	var data = axios.get('getkhoihoc').then(function(response) {
		var data1 = response.data;	
		let headTable = document.getElementById("headTablechieu");
		let bodyTable = document.getElementById("lophocchieu");
		// Tim khoi lop co nhieu lop nhat
		let max = 0;
		for (const iterator of data1) {
			if (iterator.danhsachlophoc.length > max) {
				max = iterator.danhsachlophoc.length;
			}
		}
      // Render Header truoc
      for (const iterator of data1) {
      	var chkbox = document.createElement('input');
      	chkbox.setAttribute("type", "checkbox");
      	chkbox.setAttribute("value", iterator.id);
      	chkbox.setAttribute("data-khoi", iterator.id);
      	var text = document.createTextNode(' '+iterator.tenkhoi);
      	let th = document.createElement("th");    

      	chkbox.onclick = function (e) {
      		let chkClass = document.querySelectorAll(`.classRoom[data-khoi="${e.target.dataset.khoi}"]`);
      		for (const classRoom of chkClass) {
      			classRoom.checked = e.target.checked;
      		}
      	};  	

      	th.setAttribute("data-khoi", iterator.id);
      	th.appendChild(chkbox);   
      	th.appendChild(text);     
      	headTable.appendChild(th);
      }
      // Render phan than(tbody)
      let className = [];
      // Lap theo so lop hoc lon nhat
      for (let position = 0; position < max; position++) {
      	let tr = document.createElement("tr");
      	for (const iterator of data1) {
      		let td = document.createElement("td");
      		var idlop = iterator.danhsachlophoc[position];
      		if (iterator.danhsachlophoc[position] != undefined) {
      			var chkbox = document.createElement('input');
      			chkbox.setAttribute("type", "checkbox");
      			chkbox.setAttribute("class", "classRoom");
      			chkbox.setAttribute("value", idlop.id);
      			chkbox.setAttribute("data-khoi",iterator.danhsachlophoc[position].khoi);
      			var text = document.createTextNode(' '+iterator.danhsachlophoc[position].tenlop);
      			td.appendChild(chkbox);
      			td.setAttribute("class", "lophoc");
      			td.appendChild(text);
      			tr.appendChild(td);
      		} else {
      			tr.appendChild(td);
      		}
      	}
      	bodyTable.appendChild(tr);
      }
  });
}

function checklophocsang(idmon,data2){
	var datachonlopsang = data2.filter(function(items){
		if(items.mamonhoc == idmon.id && items.buoi == 0){
			return items;
		}
	});
	if(datachonlopsang == ""){
		var table = document.getElementById ('tablelopsang');
		for (var i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = false;
		}
	}else{
		var table = document.getElementById ('tablelopsang');
		var checkboxes = table.querySelectorAll ('input[type=checkbox].classRoom');
		for (var i = 0; i < checkboxes.length; i++) {
			var chek = checkboxes[i].defaultValue;
			datachonlopsang.filter(function(items){
				if(items.malop == chek){
					checkboxes[i].checked = true;
				}
			});
		}
	}
}


function checklophocchieu(idmon,data2){
	var datachonlopchieu = data2.filter(function(items){
		if(items.mamonhoc == idmon.id && items.buoi == 1){
			return items;
		}
	});
	if(datachonlopchieu == ""){
		var table = document.getElementById ('tablelopchieu');
		var checkboxes = table.querySelectorAll ('input[type=checkbox].classRoom');
		for (var i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = false;
		}
	}else{
		var table = document.getElementById ('tablelopchieu');
		var checkboxes = table.querySelectorAll ('input[type=checkbox].classRoom');
		for (var i = 0; i < checkboxes.length; i++) {
			var chek = checkboxes[i].defaultValue;
			datachonlopchieu.filter(function(items){
				if(items.malop == chek){
					checkboxes[i].checked = true;
				}
			});
		}
	}
}


var datachontietmon;
var datachonlops;
var datachonlopc;
$('#luuchonlops').click(function (){
	var grid = document.getElementById("tablelopsang");
	var checkBoxes = grid.getElementsByClassName("classRoom");
	var id = [];
	for (var i = 0; i < checkBoxes.length; i++) {
		if (checkBoxes[i].checked) {
			var ids = checkBoxes[i].defaultValue;
			id.push(ids);
		}
	}
	var idmon = datachonlops;
	axios.post('rangbuoctiettranhchonlops',{monhoc:idmon,lops:id}).then(function(response) {
		var data1 = response.data;
		$('#chonlopsang').modal('toggle');
		rangbuoctiettranh();
		var dataGrid = $("#girdrangbuoctiettranh").dxDataGrid("instance");
		dataGrid.refresh();
	});
})



$('#luuchonlopc').click(function (){
	var grid = document.getElementById("tablelopchieu");
	var checkBoxes = grid.getElementsByClassName("classRoom");
	var id = [];
	for (var i = 0; i < checkBoxes.length; i++) {
		if (checkBoxes[i].checked) {
			var ids = checkBoxes[i].defaultValue;
			id.push(ids);
		}
	}
	var idmon = datachonlopc;
	axios.post('rangbuoctiettranhchonlopc',{monhoc:idmon,lopc:id}).then(function(response) {
		var data1 = response.data;
		$('#chonlopchieu').modal('toggle');
		rangbuoctiettranh();
		var dataGrid = $("#girdrangbuoctiettranh").dxDataGrid("instance");
		dataGrid.refresh();
	});	
})




$('#luuchontiet').click(function (){
	var idmon = datachontietmon;
	var tiet =[];	
	var mucrangbuoc = [];
	var table = document.getElementById ('girdchontiet');
	var checkboxes = table.querySelectorAll ('input[type=checkbox]');
	var select = table.querySelectorAll ('select');
	for (var i = 0; i < checkboxes.length; i++) {
		if(checkboxes[i].checked == true){
			if(checkboxes[i].id == 0){
				tiet.push(0);
			}else if(checkboxes[i].id == 1){
				tiet.push(1);
			}else if(checkboxes[i].id == 2){
				tiet.push(2);
			}else if(checkboxes[i].id == 3){
				tiet.push(3);
			}else if(checkboxes[i].id == 4){
				tiet.push(4);
			}else if(checkboxes[i].id == 5){
				tiet.push(5);
			}else if(checkboxes[i].id == 6){
				tiet.push(6);
			}else if(checkboxes[i].id == 7){
				tiet.push(7);
			}else if(checkboxes[i].id == 8){
				tiet.push(8);
			}else if(checkboxes[i].id == 9){
				tiet.push(9);
			}
			
			var sl = select[i].value;
			mucrangbuoc.push(sl);
		}
	}


	axios.post('rangbuoctiettranhchontiet',{monhoc:idmon,tiet:tiet,mucrangbuoc:mucrangbuoc }).then(function(response) {
		var data1 = response.data;
		$('#chontiet').modal('toggle');
		// Swal.fire({
		// 	title: 'Lưu',
		// 	text: 'Đã lưu thành công',
		// 	icon: 'success',
		// 	confirmButtonText: 'OK'
		// });
		rangbuoctiettranh();
		var dataGrid = $("#girdrangbuoctiettranh").dxDataGrid("instance");
		dataGrid.refresh();
	});
});