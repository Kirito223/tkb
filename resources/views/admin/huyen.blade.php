@extends('master')
@section('title','Huyện')
@section('content')


<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Danh sách huyện</h4>
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
                <div id="girdhuyen"></div>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    
    function reloadhuyen(){
      loadhuyen();
      var dataGrid = $("#girdhuyen").dxDataGrid("instance");
      dataGrid.refresh();
    }

    function loadhuyen() {
        var data = axios.get('getlisthuyen').then(function (response) {
            var data1 = response.data;
            var datas = data1.map(function(value, label) {
                let data = value;
                let stt = label + 1;
                var datas = Object.assign(data, {
                    stt: stt.toString()
                });
                return datas;
            });
            $("#girdhuyen").dxDataGrid({
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
                columns: [{
                    caption: "STT",
                    dataField: "stt",
                    width: 50,
                    allowEditing: false,
                },{
                    caption: "Tên huyện",
                    dataField: "tenhuyen",
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
                                    var id = options.data.mahuyen;
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
                                            axios.post('delhuyen', {
                                                id: id
                                            }).then(function(response) {
                                                var data = response.data;
                                                Swal.fire(
                                                    'Xoá!',
                                                    'Xoá thành công.',
                                                    'success'
                                                )
                                                reloadhuyen();
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
                    if (e.data.tenhuyen === undefined) {
                        var addtenhuyen = "";
                    } else {
                        var addtenhuyen= e.data.tenhuyen;
                    }
                    axios.post('addhuyen', {
                        tenhuyen: addtenhuyen
                    }).then(function(response) {
                        var data = response.data;
                        Swal.fire({
                            title: 'Lưu',
                            text: 'Đã thêm mới thành công',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        reloadhuyen();
                    });
                },

                onRowUpdating: function(e) {
                    var id = e.oldData.mahuyen;
                    if (e.newData.tenhuyen === undefined) {
                        var updatetenhuyen = e.oldData.tenhuyen;
                    } else {
                        var updatetenhuyen = e.newData.tenhuyen;
                    }

                    axios.post('updatehuyen', {
                        id:id,
                        tenhuyen: updatetenhuyen
                    }).then(function(response) {
                        var data = response.data;
                        Swal.fire({
                            title: 'Lưu',
                            text: 'Đã cập nhật thành công',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        reloadhuyen();
                    });
                },

                
            });
        });
    }

    window.onload = function() {
        loadhuyen();
    }

</script>
@endsection