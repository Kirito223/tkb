function rangbuoctranh2monxepcungbuoi(){
	var data = axios.get('getlistrangbuoctranh2moncungbuoi').then(function(response) {
		var data1 = response.data[0].monhoc;
		var data2 = response.data[0].rangbuoctranh2moncungbuoi;
		var datas = data1.map(function(value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {
				stt: stt.toString()
			});
			return datas;
		});
		$("#girdrangbuoctranh2monxepcungbuoi").dxDataGrid({
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
				caption: "Môn học tránh xếp cùng buổi",
				cellTemplate: function (container, options) {
					var mon = options.data.id;			
					var rangbuocmontranh = data2;
					var mondkxep = [];
					var locmon = [];
					var lucky = rangbuocmontranh.filter(function(items){
						var i = locmon.findIndex(x => x == items.montranh);
						if (i <= -1) {
							if(mon == items.mamonhoc ){
								locmon.push(items.montranh);
								var text = items.tenmonhoc + ',';
								mondkxep.push(text);							
							}
						}
					});
					$("<div>").html(mondkxep).appendTo(container);
				}
			},{
				caption: "Chọn môn",
				cellTemplate: function (container, options) {
					$("<div>").dxButton({
						stylingMode: "contained",
						text: "Chọn môn",
						type: "default",
						width: 100,
						onClick: function() {							
							var idmon = options.data;
							dataidmon = idmon.id;
							var datarb = data2;
							$('#montranh').html('<h4 class="modal-title">Chọn môn tránh xếp cùng buổi với môn: '+ idmon.tenmonhoc +'</h4>');
							$("#chonmontranh").modal('show');
							chonmon(idmon,datarb,data1);
						}
					}).appendTo(container);
				},
				width:100,
			}],
		});
	});
}




function chonmon(idmon,datarb,datas){
	var datachonmon = datarb.filter(function(items){
		if(items.mamonhoc == idmon.id){
			return items;
		}
	});
	var id = idmon.id;
	var datass = datas.filter(function(items){
		if(items.id != id){
			return items;
		}
	});
	$("#girdchonmon").dxDataGrid({
		dataSource: datass,
		showBorders: true,
		sorting: {
			mode: "multiple"
		},
		allowColumnResizing: true,
		columnResizingMode: "widget",
		scrolling: {
			mode: 'infinite'
		},
		height:600,
		columns: [
		{
			caption: "Chọn môn",
			cellTemplate: function (container, options) {
				var aa = $("<div>").html('<input type="checkbox" id='+options.data.id+' value="">').appendTo(container);	
				datachonmon.filter(function(items){ 
					if(options.data.id == items.id){
						document.getElementById(options.data.id).checked = true;
					}
				});	
			},
		},
		{
			caption: "Tên môn",
			dataField: "tenmonhoc",
		},
		{
			caption: "Mức ràng buộc",
			cellTemplate: function (container, options) {
				$("<div>").html('<select class="form-control input-xs" id="mucrangbuoc'+options.data.id+'"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select>').appendTo(container);
				datachonmon.filter(function(items){ 
					if(options.data.id == items.id){
						$('#mucrangbuoc'+options.data.id+'').val(items.mucrangbuoc);
					}
				});					
			},
		}
		],
	});
}

var dataidmon;
$('#luuchonmon').click(function (){
	var idmon = dataidmon;
	var montranh = [];
	var mucrangbuoc = [];
	var table = document.getElementById ('girdchonmon');
	var checkboxes = table.querySelectorAll ('input[type=checkbox]');
	var select = table.querySelectorAll ('select');
	for (var i = 0; i < checkboxes.length; i++) {
		if(checkboxes[i].checked == true){
			montranh.push(checkboxes[i].id);
			var sl = select[i].value;
			mucrangbuoc.push(sl);
		}
	}
	axios.post('rangbuoctranh2mon',{monhoc:idmon,montranh:montranh,mucrangbuoc:mucrangbuoc }).then(function(response) {
		$('#chonmontranh').modal('toggle');
		// Swal.fire({
		// 	title: 'Lưu',
		// 	text: 'Đã lưu thành công',
		// 	icon: 'success',
		// 	confirmButtonText: 'OK'
		// });
		rangbuoctranh2monxepcungbuoi();
		var dataGrid = $("#girdrangbuoctranh2monxepcungbuoi").dxDataGrid("instance");
		dataGrid.refresh();
	});
	

});
