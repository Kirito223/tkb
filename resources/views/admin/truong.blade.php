@extends('master')
@section('title','Trường')
@section('content')


<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Danh sách trường</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements" style="padding-top: 10px">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collpase show">
            <div class="card-body">
                <div id="girdtruong"></div>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    
    function reloadtruong(){
      loadtruong();
      var dataGrid = $("#girdtruong").dxDataGrid("instance");
      dataGrid.refresh();
    }

    function loadtruong() {
        var data = axios.get('getlisttruong').then(function (response) {
            var data1 = response.data;
            var datas = data1.map(function(value, label) {
                let data = value;
                let stt = label + 1;
                var datas = Object.assign(data, {
                    stt: stt.toString()
                });
                return datas;
            });
            axios.get('getlisthuyen').then(function(response){
                var datahuyen = response.data;
                var datacaphoc=[{
                    "id": 1,
                    "tencap": "Tiểu học"
                },{
                    "id": 2,
                    "tencap": "Trung học cơ sở"
                },{
                    "id": 3,
                    "tencap": "Trung học phổ thông"
                }]
                $("#girdtruong").dxDataGrid({
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
                    //     visible: true,
                    //     applyFilter: "auto"
                    // },
                    searchPanel: {
                        visible: true,
                        width: 240,
                        placeholder: "Tìm kiếm..."
                    },
                    // selection: {
                    //  mode: "single"
                    // },                   
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
                    onEditorPreparing(e) {
                        if (e.dataField === "mahuyen" && e.parentType === "dataRow") {
                            e.editorOptions.placeholder = "Chọn huyện";
                        }
                        if (e.dataField === "caphoc" && e.parentType === "dataRow") {
                            e.editorOptions.placeholder = "Chọn cấp học";
                        }
                    },
                    columns: [{
                        caption: "STT",
                        dataField: "stt",
                        width: 50,
                        allowEditing: false,
                    },{
                        caption: "Tên trường",
                        dataField: "tentruong",
                    },{
                        caption: "Huyện",
                        dataField: "mahuyen",
                        lookup: {
                            dataSource: datahuyen,
                            displayExpr: "tenhuyen",
                            valueExpr: "mahuyen",
                        }
                    }, {
                        caption: "Cấp học",
                        dataField: "caphoc",
                        lookup: {
                            dataSource: datacaphoc,
                            displayExpr: "tencap",
                            valueExpr: "id",
                        }
                    },{
                        caption: "Điểm trường",
                        dataField: "loaitruong",
                        dataType: "number"
                    },{
                        fixed: true,
                        fixedPosition: "right",
                        caption: "Xóa",
                        cellTemplate: function(container, options) {
                            container.addClass("center");
                            $("<div>")
                                .dxButton({
                                    template: function(e) {
                                        return $('<i class="fa fa-trash-o"></i>');
                                    },
                                    onClick: function(e) {
                                        var id = options.data.matruong;
                                        Swal.fire({
                                            title: 'Xoá?',
                                            text: "Bạn có muốn xoá!",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'OK'
                                        }).then((result) => {
                                            if (result.value) {
                                                axios.post('deltruong', {
                                                    id: id
                                                }).then(function(response) {
                                                    var data = response.data;
                                                    Swal.fire(
                                                        'Xoá!',
                                                        'Xoá thành công.',
                                                        'success'
                                                    )
                                                    reloadtruong();
                                                });
                                            }
                                        })
                                    },
                                })
                                .appendTo(container);
                        },
                        width: 50,
                    }],
                    onRowInserting: function(e) {
                        if (e.data.tentruong === undefined) {
                            var addtentruong = "";
                        } else {
                            var addtentruong= e.data.tentruong;
                        }

                        if (e.data.mahuyen === undefined) {
                            var addmahuyen = "";
                        } else {
                            var addmahuyen= e.data.mahuyen;
                        }

                        if (e.data.caphoc === undefined) {
                            var addcaphoc = "";
                        } else {
                            var addcaphoc= e.data.caphoc;
                        }

                        if (e.data.loaitruong === undefined) {
                            var addloaitruong = "";
                        } else {
                            var addloaitruong= e.data.loaitruong;
                        }
                        axios.post('addtruong', {
                            tentruong: addtentruong,
                            mahuyen: addmahuyen,
                            caphoc: addcaphoc,
                            loaitruong: addloaitruong
                        }).then(function(response) {
                            var data = response.data;
                            Swal.fire({
                                title: 'Lưu',
                                text: 'Đã thêm mới thành công',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            reloadtruong();
                        });
                    },

                    onRowUpdating: function(e) {
                        var id = e.oldData.matruong;
                        if (e.newData.tentruong === undefined) {
                            var updatetentruong = e.oldData.tentruong;
                        } else {
                            var updatetentruong = e.newData.tentruong;
                        }

                        if (e.newData.mahuyen === undefined) {
                            var updatemahuyen = e.oldData.mahuyen;
                        } else {
                            var updatemahuyen = e.newData.mahuyen;
                        }

                        if (e.newData.caphoc === undefined) {
                            var updatecaphoc = e.oldData.caphoc;
                        } else {
                            var updatecaphoc = e.newData.caphoc;
                        }

                        if (e.newData.loaitruong === undefined) {
                            var updateloaitruong = e.oldData.loaitruong;
                        } else {
                            var updateloaitruong = e.newData.loaitruong;
                        }

                        axios.post('updatetruong', {
                            id:id,
                            tentruong: updatetentruong,
                            mahuyen: updatemahuyen,
                            caphoc: updatecaphoc,
                            loaitruong: updateloaitruong
                        }).then(function(response) {
                            var data = response.data;
                            Swal.fire({
                                title: 'Lưu',
                                text: 'Đã cập nhật thành công',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            reloadtruong();
                        });
                    },

                    
                });
            });
            
        });
    }

    window.onload = function() {
        loadtruong();
    }

</script>
@endsection