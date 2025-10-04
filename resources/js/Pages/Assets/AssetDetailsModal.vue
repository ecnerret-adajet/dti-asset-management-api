<template>
  <div>
    <!-- Modal Backdrop -->
    <div
      v-if="show"
      class="modal fade show"
      style="display: block; background-color: rgba(0, 0, 0, 0.5)"
      tabindex="-1"
      role="dialog"
      aria-labelledby="assetDetailsModalLabel"
      aria-hidden="true"
    >
      <!-- Modal Dialog -->
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h5 class="modal-title" id="assetDetailsModalLabel">Asset Details</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
              @click="closeModal"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <!-- Modal Body -->
          <div class="modal-body">
            <div v-if="asset" class="container-fluid">
              <div class="row mb-4">
                <div class="col-md-4 text-center">
                  <div class="image-container mb-3">
                    <img 
                      :src="`${baseUrl}/${asset.image_path}`" 
                      class="img-fluid rounded asset-image" 
                      alt="Asset Image"
                      @click="openImageModal(asset.image_path)"
                    />
                  </div>
                </div>
                <div class="col-md-8">
                  <h3 class="font-weight-bold text-capitalize">{{ asset.name }}</h3>
                  <p class="text-muted">{{ asset.description }}</p>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <th class="bg-light">Storage Location</th>
                        <td>{{ asset?.location?.name }} / {{ asset.storage_location }}</td>
                      </tr>
                      <tr>
                        <th class="bg-light">Model</th>
                        <td>{{ asset.model }}</td>
                      </tr>
                      <tr>
                        <th class="bg-light">Serial Number</th>
                        <td>{{ asset.serial_number }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <th class="bg-light">Part Number</th>
                        <td>{{ asset.part_number ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <th class="bg-light">Supplier</th>
                        <td>{{ asset?.supplier?.name ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <th class="bg-light">Stock Quantity</th>
                        <td>{{ asset.current_value }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Modal Footer -->
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
              @click="closeModal"
            >
              Close
            </button>
            <a
              :href="`/inventory/${asset.id}/show`"
              class="btn btn-primary"
            >
              View Full Details
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  asset: {
    type: Object,
    default: () => ({})
  }
});

const emit = defineEmits(['close', 'openImageModal']);

const baseUrl = window.location.origin;

const closeModal = () => {
  emit('close', false);
};

const openImageModal = (imagePath) => {
  emit('openImageModal', imagePath);
};
</script>

<style scoped>
.asset-image {
  max-height: 200px;
  object-fit: contain;
  cursor: pointer;
}

.image-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 200px;
}
</style>
