<div class="container mt-3">
	<h4 class="text-center">Produk</h4>
	<md-button class="md-raised md-primary" data-toggle="modal" data-target="#Modaltambah" ng-click="clearModal()">Tambah</md-button>
	<!-- <div class="input-search">
		<input type="text" name="search" ng-model="keyword" class="form-control form-control-sm mb-3 w-25" placeholder="Search...">
	</div> -->
	<a href="#/guru">Guru</a>
	<table id="mytable" ng-if="siswa.length > 0" class="table table-striped table-bordered table-hover w-100">
		<thead>
			<tr>
				<td>No</td>
				<td>ID Siswa</td>
				<td>Nama Siswa</td>
				<td>Alamat Siswa</td>
				<td class="text-center">Aksi</td>
			</tr>
		</thead>
		<tbody ng-repeat="x in siswa | filter: keyword"  ng-if="siswa.length > 0">
			<tr ng-if="!siswa.length">
				<td>No record loaded yet!</td>
			</tr>
			<tr>
				<td>{{ $index + 1 }}</td>
				<td>{{ x.id_siswa }}</td>
				<td>{{ x.nama_siswa }}</td>
				<td>{{ x.alamat_siswa }}</td>
				<td class="text-center">
					<md-button class="md-raised md-warn btn-sm" ng-click="edit(x.id_siswa)">Edit</md-button>
					<md-button class="md-raised" ng-click="hapusSiswa(x.id_siswa)">Hapus</md-button>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="modal fade" id="Modaltambah">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<md-progress-linear class="prog-linear rounded-left rounded-right" style="display: none;"></md-progress-linear>
			<form action="#" method="POST" role="form" name="myForm">
				<div class="modal-header">
					<h4 class="modal-title">{{ modalTitle }} Siswa</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<md-input-container class="md-block" flex-gt-sm>
				            <label>ID Siswa</label>
				            <input required ng-model="input.id_siswa" minlength="5" maxlength="10" name="idsiswa" ng-disabled="disabledIDSiswa" autofocus>
				            <div ng-messages="myForm.idsiswa.$error" role="alert">
					          	<div ng-message-exp="['required', 'minlength', 'maxlength']">
						            ID ini harus diisi dengan minimal 5 karakter dan maksimal 10 karakter
						        </div>
					        </div>
				        </md-input-container>
					</div>
					<div class="form-group my-4">
						<md-input-container class="md-block" flex-gt-sm>
				            <label>Nama Siswa</label>
				            <input required type="text" minlength="5" maxlength="50" ng-model="input.nama_siswa" name="namasiswa">
				            <div ng-messages="myForm.namasiswa.$error" role="alert">
					          	<div ng-message-exp="['required', 'minlength', 'maxlength']">
						            Nama ini harus diisi dengan minimal 5 karakter dan maksimal 50 karakter
						        </div>
					        </div>
				        </md-input-container>
					</div>
					<div class="form-group">
						<md-input-container class="md-block" flex-gt-sm>
				            <label>Alamat Siswa</label>
				            <input required type="text" minlength="10" maxlength="100" ng-model="input.alamat_siswa" name="alamatsiswa">
				            <div ng-messages="myForm.alamatsiswa.$error" role="alert">
					          	<div ng-message-exp="['required', 'minlength', 'maxlength']">
						            Alamat ini harus diisi dengan minimal 10 karakter dan maksimal 100 karakter
						        </div>
					        </div>
				        </md-input-container>
					</div>
				</div>
				<div class="modal-footer">
					<md-button data-dismiss="modal">Close</md-button>
					<div ng-if="modalTitle == 'Tambah'">
						<md-button class="md-raised md-primary tambah" ng-disabled="disabledTambah" ng-click="tambahSiswa()">Simpan</md-button>
					</div>
					<div ng-if="modalTitle == 'Ubah'">
						<md-button class="md-raised md-primary ubah" ng-disabled="disabledUbah" ng-click="ubahSiswa()">Ubah</md-button>
					</div>
				</div>
			</form>	
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('_partials/v_footer'); ?> 

<script type="text/javascript">
	// $('#mytable').DataTable();
	var app = angular.module('myApp', ['ngRoute','ngMaterial','ngMessages']);
		app.config(function($routeProvider){
			$routeProvider
				.when("/",{
					templateUrl: 'siswa/v_list_siswa.php',
					controller: 'myController'
				})
				.when("/guru",{
					templateUrl: 'guru/v_list_guru.php',
					controller: 'guruController'
				})
		});
		app.controller('myController', function($scope, $mdToast, $http) {
			$scope.clearModal = function() {
				$scope.input = {};
			}
			$scope.input = {};
			$scope.siswa = [];
			$scope.disabledTambah = false;
			$scope.disabledUbah = false;
			$scope.disabledIDSiswa = false; 
			$scope.modalTitle = 'Tambah';

			$('#Modaltambah').on('show.bs.modal', function(){
				$scope.clearModal();
			});

			$scope.getSiswa = function() {
				$http({
					method: 'GET',
					url: '<?php echo site_url(); ?>siswa/data_siswa'
				}).then(function success(e) {
					$scope.siswa = e.data;
				}, function error(e) {
					console.log('Gagal');
				});
			};
			$scope.getSiswa();
			$scope.tambahSiswa = function() {
				$('.prog-linear').show();
				var btnTambah = angular.element('.tambah');
				btnTambah.html('Please Wait...');
				$scope.disabledTambah = true;
				var data = $scope.input;
				console.log(data);
				$http({
					method: 'POST',
					url: '<?php echo site_url(); ?>siswa/tambah',
					data: data
				}).then(function success(data) {
					$('.prog-linear').hide();
					btnTambah.html('Simpan');
					$scope.disabledTambah = false;
					var modal_element = angular.element('#Modaltambah');
					modal_element.modal('hide');
					$mdToast.show (
		                $mdToast.simple()
		                .textContent('Sukses insert data!')   
		                .action('CLOSE')
		                .highlightAction(true)
		                .highlightClass('md-accent')
		                .position('top right')                    
		                .hideDelay(3000)
		            );
					$scope.getSiswa();
				}, function error(e) {
					console.log('Gagal insert siswa');
				});
			};
			$scope.hapusSiswa = function(id) {
				var conf = confirm('Yakin mau menghapus?');
				if (conf == true) {
					$http({
						method: 'GET',
						url: '<?php echo site_url(); ?>siswa/hapus/'+id
					}).then(function success(e){
						$mdToast.show (
			                $mdToast.simple()
			                .textContent('Sukses hapus data!')   
			                .action('CLOSE')
			                .highlightAction(true)
			                .highlightClass('md-accent')
			                .position('top right')                    
			                .hideDelay(3000)
			            );
						$scope.getSiswa();
					}, function error(e){
						console.log('Gagal menghapus siswa');
					});
				}
			};
			$scope.edit = function(id) {
				$scope.modalTitle = 'Ubah';
				var modal_element = angular.element('#Modaltambah');
				modal_element.modal('show');
				var idsiswa = id;
				console.log(idsiswa);
				$http({
					method: 'GET',
					url: '<?php echo site_url(); ?>siswa/get_siswa/'+idsiswa
				}).then(function success(res){
					console.log(res);
					$scope.disabledIDSiswa = true; 
					$scope.input = res.data;
				})
			};
			$scope.ubahSiswa = function(){
				$('.prog-linear').show();
				var btnUbah = angular.element('.ubah');
				btnUbah.html('Please Wait...');
				$scope.disabledUbah = true;
				var data = $scope.input;
				console.log(data);
				$http({
					method: 'POST',
					url: '<?php echo site_url(); ?>siswa/ubah/'+$scope.input.id_siswa,
					data: data
				}).then(function success(e){
					$('.prog-linear').hide();
					btnUbah.html('Ubah');
					$scope.disabledTambah = false;
					var modal_element = angular.element('#Modaltambah');
					modal_element.modal('hide');
					$mdToast.show (
		                $mdToast.simple()
		                .textContent('Sukses update data!')   
		                .action('CLOSE')
		                .highlightAction(true)
		                .highlightClass('md-accent')
		                .position('top right')                    
		                .hideDelay(3000)
		            );
					$scope.getSiswa();
				}, function error(e){
					console.log('Gagal update siswa');
				});
			};
		});
</script>
