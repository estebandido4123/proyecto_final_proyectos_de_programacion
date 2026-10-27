<!-- Mensaje de alerta flashdata -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show text-start py-2 px-3 mb-3" style="border-radius: 15px; font-size: 0.85rem;" role="alert">
        <i class="fa-solid fa-circle-exclamation me-1"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>