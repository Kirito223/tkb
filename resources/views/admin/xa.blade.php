@extends('master')
@section('title','Xã')
@section('content')


<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Danh sách xã</h4>
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
                <div id="girdxa"></div>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    
    function reloadxa(){
      loadxa();
      var dataGrid = $("#girdxa").dxDataGrid("instance");
      dataGrid.refresh();
    }

    function loadxa() {
        var data = axios.get('getlistxa').then(function (response) {
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
                $("#girdxa").dxDataGrid({
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
                    },
                    columns: [{
                        caption: "STT",
                        dataField: "stt",
                        width: 50,
                        allowEditing: false,
                    },{
                        caption: "Tên xã",
                        dataField: "tenxa",
                    },{
                        caption: "Huyện",
                        dataField: "mahuyen",
                        lookup: {
                            dataSource: datahuyen,
                            displayExpr: "tenhuyen",
                            valueExpr: "mahuyen",
                        }
                    }, {
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
                                        var id = options.data.id;
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
                                                axios.post('delxa', {
                                                    id: id
                                                }).then(function(response) {
                                                    var data = response.data;
                                                    Swal.fire(
                                                        'Xoá!',
                                                        'Xoá thành công.',
                                                        'success'
                                                    )
                                                    reloadxa();
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
                        if (e.data.tenxa === undefined) {
                            var addtenxa = "";
                        } else {
                            var addtenxa= e.data.tenxa;
                        }

                        if (e.data.mahuyen === undefined) {
                            var addmahuyen = "";
                        } else {
                            var addmahuyen= e.data.mahuyen;
                        }
                        axios.post('addxa', {
                            tenxa: addtenxa,
                            mahuyen: addmahuyen
                        }).then(function(response) {
                            var data = response.data;
                            Swal.fire({
                                title: 'Lưu',
                                text: 'Đã thêm mới thành công',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            reloadxa();
                        });
                    },

                    onRowUpdating: function(e) {
                        var id = e.oldData.id;
                        if (e.newData.tenxa === undefined) {
                            var updatetenxa = e.oldData.tenxa;
                        } else {
                            var updatetenxa = e.newData.tenxa;
                        }

                        if (e.newData.mahuyen === undefined) {
                            var updatemahuyen = e.oldData.mahuyen;
                        } else {
                            var updatemahuyen = e.newData.mahuyen;
                        }

                        axios.post('updatexa', {
                            id:id,
                            tenxa: updatetenxa,
                            mahuyen: updatemahuyen
                        }).then(function(response) {
                            var data = response.data;
                            Swal.fire({
                                title: 'Lưu',
                                text: 'Đã cập nhật thành công',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            reloadxa();
                        });
                    },

                    
                });
            });
            
        });
    }

    window.onload = function() {
        loadxa();
    }

</script>
@endsection