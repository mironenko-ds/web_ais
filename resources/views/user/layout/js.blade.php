  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Готов уходить?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Выберите «Выход из системы» ниже, если вы готовы завершить текущий сеанс.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Отмена</button>
          <a class="btn btn-primary" href="#"
          onclick="event.preventDefault();
              document.getElementById('logout-form').submit();"
          >Выход из системы</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
           </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->

  <script src="{{ asset('vendor/jquery/jquery.min.js') }}" defer></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}" defer></script>

  <!-- Page level plugin JavaScript-->
  <script src="{{ asset('vendor/chart.js/Chart.min.js') }}" defer></script>
  <script src="{{ asset('vendor/datatables/jquery.dataTables.js') }}" defer></script>
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.js') }}" defer></script>


  <!-- Custom scripts for all pages-->
  <script src="{{ asset('js/sb-admin.min.js') }}" defer></script>

  <!-- Demo scripts for this page-->
  <script src="{{ asset('js/demo/datatables-demo.js') }}" defer></script>
  <script src="{{ asset('js/demo/chart-area-demo.js') }}" defer></script>

  <!-- Feather icons-->
  <script src="{{ asset('js/feather.js') }}" defer></script>
