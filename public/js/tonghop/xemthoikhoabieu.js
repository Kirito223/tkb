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
		},{
			caption:"Số học sinh",
			// dataField: "demdsgv"
		},	{
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
                        	var datadsgv = options.data.danhsachgv;
                        	var datadslop = options.data.danhsachlop;
                        	var datadskhoi = options.data.danhsachkhoihoc;
                        	loaddanhsachgv(datadsgv);
                        	// loaddanhsachlop(datadslop);
                        	loaddanhsachkhoilop(datadskhoi,datadslop);
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
	$('#idselectgv').append("<option></option>");
	for(var i= 0; i< datadsgv.length;i++){
		var option = document.createElement("option");
	    option.value = datadsgv[i].id;
	    option.text = datadsgv[i].hovaten;
	    selectListGv.appendChild(option);
	}
	$('#idselectgv').select2({ width: '50%'});

}

function loaddanhsachkhoilop(datadskhoi,datadslop){
	var datadskhoi = datadskhoi;
	var datadslop = datadslop;
	var selectListKhoi = document.getElementById('idselectkhoi');
	var selectListLop = document.getElementById('idselectlop');
	$('#idselectkhoi').append("<option></option>");
	for(var i= 0; i< datadskhoi.length;i++){
		var option = document.createElement("option");
	    option.value = datadskhoi[i].id;
	    option.text = datadskhoi[i].tenkhoi;
	    selectListKhoi.appendChild(option);
	}

	$('#idselectkhoi').on('change',function(){
		$('#idselectlop').find('option').remove();
		$('#idselectlop').append("<option></option>");
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

}

window.onload = function() {
	loaddanhsachtruong();
	$("#bangdstruong").on('show.bs.collapse', function(){
    	document.getElementById("formxemtkb").style.display = "none";
    	$('#idselectgv').find('option').remove();
    	$('#idselectlop').find('option').remove();
    	$('#idselectkhoi').find('option').remove();
  	});

  	$('#idselectgv').on('change',function(){
  		var sel = document.getElementById("idselectgv");
		var text= sel.options[sel.selectedIndex].text;
  		$('#idtengv').text(text);
  		document.getElementById("cardxeptkbgiaovien").style.display = "block";
  	});

  	$('#idselectlop').on('change',function(){
  		var sel = document.getElementById("idselectlop");
		var text= sel.options[sel.selectedIndex].text;
  		$('#idtenlop').text(text);
  		document.getElementById("cardxeptkblop").style.display = "block";
  	});
}
