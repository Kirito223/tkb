function nhapdanhsachgv() {
	var data = axios.get('getdanhsachgv').then(function(response) {
		var data1 = response.data;
		var datas = data1.map(function(value, label) {
			let data = value;
			let stt = label + 1;
			var datas = Object.assign(data, {
				stt: stt.toString()
			});
			return datas;
		});
		$("#girdnhapdanhsachgv").dxDataGrid({
			dataSource: datas,
			showBorders: true,
      paging: {
       pageSize: 30
     },
			height: 800,
     scrolling: {
      mode: 'infinite'
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
   selection: {
     mode: "single"
   },
   editing: {
     mode: "batch",
     allowUpdating: true,
     selectTextOnEditStart: true,
     startEditAction: "click",

     allowAdding: true,
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
     caption: "Họ và tên",
     dataField: "hovaten",
     width: 150,
   }, {
     caption: "Bí danh",
     dataField: "bidanh",
     width: 100,
   }, {
     caption: "Số điện thoại",
     dataField: "dienthoai",
     width: 150,
   }, {
     caption: "Email",
     dataField: "email",
   }],
            // select data row
            onSelectionChanged: function(selectedItems) {},

            onRowUpdating: function(e) {
            	var id = e.oldData.id;
            	if (e.newData.hovaten === undefined) {
            		var addgvten = e.oldData.hovaten;
            	} else {
            		var addgvten = e.newData.hovaten;
            	}

            	if (e.newData.bidanh === undefined) {
            		var addgvbidanh = e.oldData.bidanh;
            	} else {
            		var addgvbidanh = e.newData.bidanh;
            	}

            	if (e.newData.dienthoai === undefined) {
            		var addgvsdt = e.oldData.dienthoai;
            	} else {
            		var addgvsdt = e.newData.dienthoai;
            	}

            	if (e.newData.email === undefined) {
            		var addgvemail = e.oldData.email;
            	} else {
            		var addgvemail = e.newData.email;
            	}

            	axios.post('updatedanhsachgv', {
            		id: id,
            		hovaten: addgvten,
            		bidanh: addgvbidanh,
            		dienthoai: addgvsdt,
            		email: addgvemail
            	}).then(function(response) {
            		var data = response.data;
            		Swal.fire({
            			title: 'Lưu',
            			text: 'Đã lưu thành công',
            			icon: 'success',
            			confirmButtonText: 'OK'
            		});
            		reloaddsgv();
            	});
            },

            onRowInserting: function(e) {
            	if (e.data.hovaten === undefined) {
            		var addgvten = "";
            	} else {
            		var addgvten = e.data.hovaten;
            	}

            	if (e.data.bidanh === undefined) {
                var bidanh = e.data.hovaten;
                var name1 = bidanh.split(' ');
                if(name1.length < 3){
                  var first_name = name1[0];
                  var last_name1 = name1[1];
                  var first_name1 = first_name.slice(0,1);
                  var bidanhloc = first_name1 +'-'+ last_name1;
                  var addgvbidanh = bidanhloc;
                }else if(name1.length < 4){
                  var last_name1 = name1[1];
                  var last_name2 = name1[2];
                  var first_name1 = last_name1.slice(0,1);
                  var bidanhloc = first_name1 +' -'+ last_name2;
                  var addgvbidanh = bidanhloc;
                }else if(name1.length < 5){
                  var last_name2 = name1[2];
                  var last_name3 = name1[3];
                  var first_name1 = last_name2.slice(0,1);
                  var bidanhloc = first_name1 +'-'+ last_name3;
                  var addgvbidanh = bidanhloc;
                }




              } else {
                var addgvbidanh = e.data.bidanh;
              }

              if (e.data.dienthoai === undefined) {
                var addgvsdt = "";
              } else {
                var addgvsdt = e.data.dienthoai;
              }

              if (e.data.email === undefined) {
                var addgvemail = "";
              } else {
                var addgvemail = e.data.email;
              }
              axios.post('adddanhsachgv', {
                hovaten: addgvten,
                bidanh: addgvbidanh,
                dienthoai: addgvsdt,
                email: addgvemail
              }).then(function(response) {
                var data = response.data;
                Swal.fire({
                 title: 'Lưu',
                 text: 'Đã thêm mới thành công',
                 icon: 'success',
                 confirmButtonText: 'OK'
               });
                reloaddsgv();
              });
            },


            onContextMenuPreparing: function(data) {
            	if (data.target == "content") {
            		if (!data.items) data.items = [];
            		data.items.push({
            			template: function() {
            				return $("<i class='fa fa-remove'>").text(" Xóa");
            			},
            			onItemClick: function() {
            				var dataxoa = data.row.data.id;
            				xoadsgv(dataxoa);
            			}
            		});
            		data.items.push({
            			template: function() {
            				return $("<i class='fa fa-remove'>").text(" Xóa toàn bộ");
            			},
            			onItemClick: function() {
            				var dataxoahet = datas;
            				xoatoandsgv(dataxoahet);
            			}
            		});
            	}
            }
          });
});
}

function reloaddsgv(){
  nhapdanhsachgv();
  var dataGrid = $("#girdnhapdanhsachgv").dxDataGrid("instance");
  dataGrid.refresh();
}




function xoadsgv(id) {
  Swal.fire({
    title: 'Lưu',
    text: "Bạn có muốn xóa giáo viên này không",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
    if (result.value) {
      axios.post('deldanhsachgv',{id:id}).then(function (response) {
        var data = response.data;
        Swal.fire({
          position: 'center',
          icon: 'success',
          text: 'Đã xóa thành công',
          showConfirmButton: false,
          timer: 1000
        });   
        reloaddsgv();
      });
    }           
  })
}

function xoatoandsgv(id) {
  Swal.fire({
    title: 'Lưu',
    text: "Bạn có muốn xóa toàn bộ giáo viên không",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
    if (result.value) {
      axios.post('deltoanbodanhsachgv',{id:id}).then(function (response) {
        var data = response.data;
        Swal.fire({
          position: 'center',
          icon: 'success',
          text: 'Đã xóa thành công',
          showConfirmButton: false,
          timer: 1000
        });   
        reloaddsgv();
      });
    }           
  })
}