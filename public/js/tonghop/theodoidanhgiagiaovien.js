function loaddstruong(){
	axios.get('getdstruong').then(function(response) {
		var data = response.data;
		var selectListTruong = document.getElementById('idselecttruong');
		$('#idselecttruong').append("<option></option>");
		for(var i= 0; i< data.length;i++){
			var option = document.createElement("option");
		    option.value = data[i].matruong;
		    option.text = data[i].tentruong;
		    selectListTruong.appendChild(option);
		}

		$('#idselecttruong').on('change',function(){
			var matruong = $(this).val();
			var tentruong = $(this).find('option:selected').text();
			$('#idtentruong').text(tentruong);
			danhgiagiaovien(matruong);
		});

	});
}





function danhgiagiaovien(matruong) {
	var matruong = matruong;
    var data = axios.get('getdanhgiagv').then(function(response) {
        var data1 = response.data[0];
        var data1_new = [];
        for(let i=0 ; i<data1.length; i++){
        	if(data1[i].matruong == matruong){
        		data1_new.push(data1[i]);
        	}
        }
        var tengv = response.data[1];
        var tengv_new = [];
        for(let i=0 ; i<tengv.length; i++){
        	if(tengv[i].matruong == matruong){
        		tengv_new.push(tengv[i]);
        	}
        }
        var gvchuyenmon = response.data[2];
        var gvchuyenmon_new = [];
        for(let i=0 ; i<gvchuyenmon.length; i++){
        	if(gvchuyenmon[i].matruong == matruong){
        		gvchuyenmon_new.push(gvchuyenmon[i]);
        	}
        }
        var danhgiagv = response.data[3];
        var danhgiagv_new = [];
        for(let i=0 ; i<danhgiagv.length; i++){
        	if(danhgiagv[i].matruong == matruong){
        		danhgiagv_new.push(danhgiagv[i]);
        	}
        }
        $("#danhgiagiaovien").dxDataGrid({
            dataSource: data1_new,
            allowColumnReordering: true,
            showBorders: true,
            // searchPanel: {
            //     visible: true
            // },
            allowColumnResizing: true,
            columnResizingMode: "widget",
            columns: [{
                caption: "Tổ chuyên môn",
                dataField: "tentocm",

            }],
            masterDetail: {
                enabled: true,
                template: function(container, options) {
                    var currentEmployeeData = options.data.id;
                    // var datagvchuyenmon = [];
                    // gvchuyenmon.filter(function(items) {
                    // 	if(items.matochuyenmon == currentEmployeeData){
                    // 		var i = datagvchuyenmon.findIndex(x => x.magiaovien == items.magiaovien);
                    // 		if (i <= -1) {
                    // 			datagvchuyenmon.push(items);
                    // 		}
                    // 		return null;
                    // 	}
                    // });
                    $("<div>").dxDataGrid({
                        columnAutoWidth: true,
                        showBorders: true,
                        // editing: {
                        //     mode: "batch",
                        //     allowUpdating: true,
                        //     selectTextOnEditStart: true,
                        //     startEditAction: "click",
                        //     allowAdding: true,
                        // },
                        columns: [{
                            caption: "Tên giáo viên",
                            dataField: "magiaovien",
                            lookup: {
                                dataSource: tengv_new,
                                valueExpr: "id",
                                displayExpr: "hovaten"
                            },
                        }, {
                            caption: "Thời điểm đánh giá",
                            dataField: "created_at",
                            dataType: "date",
                            format: 'dd/MM/yyyy',
                        }, {
                            caption: "Hình thức",
                            dataField: "hinhthuc",
                            lookup: {
                                dataSource: [{
                                    id: 1,
                                    muc: "Chuyên đề"
                                }, {
                                    id: 2,
                                    muc: "Toàn diện"
                                }, {
                                    id: 3,
                                    muc: "Đột xuất"
                                }, {
                                    id: 4,
                                    muc: "Chưa đánh giá"
                                }],
                                valueExpr: "id",
                                displayExpr: "muc"
                            },
                        }, {
                            caption: "Xếp loại",
                            dataField: 'xeploai',
                            lookup: {
                                dataSource: [{
                                    id: 1,
                                    muc: "Tốt"
                                }, {
                                    id: 2,
                                    muc: "Khá"
                                }, {
                                    id: 3,
                                    muc: "Trung bình"
                                }, {
                                    id: 4,
                                    muc: "Chưa đạt yêu cầu"
                                }, {
                                    id: null,
                                    muc: "Chưa đánh giá"
                                }, ],
                                valueExpr: "id",
                                displayExpr: "muc"
                            },
                        }],

                        dataSource: new DevExpress.data.DataSource({
                            store: new DevExpress.data.ArrayStore({
                                key: "tochuyenmon",
                                data: danhgiagv_new
                            }),
                            filter: ["tochuyenmon", "=", options.key.id]
                        })
                    }).appendTo(container);
                }
            }

        });
    });
}


window.onload = function() {
    // danhgiagiaovien();
    loaddstruong();
    $('#idselecttruong').select2({ width: '50%'});
};