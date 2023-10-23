<script setup>
import { ref, onMounted } from "vue";
import AssetTypesApi from '../Api/AssetTypesApi';
import LocationApi from '../Api/LocationsApi';
import StatusesApi from '../Api/StatusesApi';

const assetTypesService = new AssetTypesApi();
const locationsService = new LocationApi();
const statusesService = new StatusesApi();

const errors = ref(null);
const assetTypes = ref([]);
const locations = ref([]);
const statuses = ref([]);
const selectedAssetTypes = ref([]);
const selectedLocations = ref([]);

const emit = defineEmits(['assetTypeData','locationsData','statusesData']);

const fetchAssetTypes = () => {
    return assetTypesService.list()
    .then(response => {
        assetTypes.value = response;
    })
    .catch(error => {
        errors.value = error
    });
};

const fetchLocations = () => {
    return locationsService.list()
    .then(response => {
        locations.value = response
    })
    .catch(error => {
        errors.value = error
    })
};

const fetchStatuses = () => {
    return statusesService.list()
    .then(response => {
        statuses.value = response
    })
    .catch(error => {
        errors.value = error
    })
};

// 'selectedAssetTypes', 'assetTypes'
const handleAssetTypes = (index) => {
    if(selectedAssetTypes.value.includes(index) === true) {
        return selectedAssetTypes.value.splice(index, 1);
    } else {
        return selectedAssetTypes.value.push(index);
    }
}
const handleLocations = (index) => {
    if(selectedLocations.value.includes(index) === true) {
        return selectedLocations.value.splice(index, 1);
    } else {
        return selectedLocations.value.push(index);
    }
}

const submitFilter = () => {
    emit('onAssetTypes',  selectedAssetTypes.value);
    emit('onLocations',  selectedLocations.value);
}

const reset = () => {
    selectedAssetTypes.value = [];
    selectedLocations.value = [];
}

onMounted(() => {
    fetchAssetTypes();
    fetchLocations();
    fetchStatuses();
});

</script>
<template>

    <!--begin::Forms Widget 15-->
    <div class="card card-custom gutter-b">
      <!--begin::Body-->
      <div class="card-body">
        <!--begin::Form-->
        <form @submit.prevent="submitFilter">
            <!--begin::Asset Type-->
          <div class="form-group mb-7">
            <label class="font-size-h3 font-weight-bolder text-dark mb-7"
              >Categories</label
            >
            <!--begin::Checkbox list-->
            <div v-for="(type,t) in assetTypes" :key="t" class="checkbox-list">
              <label class="checkbox checkbox-lg" :class="{ ' mb-7 ' : t != assetTypes.length -1}">
                <input type="checkbox" v-model="selectedAssetTypes[t]" @change="handleAssetTypes(t)" />
                <span></span>
                <div class="font-size-lg text-dark-75 font-weight-bold">
                  {{ type.name }}
                </div>
                <div class="ml-auto text-muted font-weight-bold">{{ type.assets_count }}</div>
              </label>
            </div>
            <!--end::Checkbox list-->
          </div>
          <!--end::Asset Type-->
          <!--begin::Locations-->
          <div class="form-group mb-7">
            <label class="font-size-h3 font-weight-bolder text-dark mb-7"
              >Locations</label
            >
            <!--begin::Checkbox list-->
            <div v-for="(location,l) in locations" :key="`loc-${l}`" class="checkbox-list">
              <label class="checkbox checkbox-lg" :class="{ ' mb-7 ' : l != locations.length -1}">
                <input type="checkbox" v-model="selectedLocations[l]" @change="handleLocations(l)" />
                <span></span>
                <div class="font-size-lg text-dark-75 font-weight-bold">
                  {{ location.name }}
                </div>
                <div class="ml-auto text-muted font-weight-bold">{{ location.assets_count }}</div>
              </label>
            </div>
            <!--end::Checkbox list-->
          </div>
          <!--end::Locations-->
          <!--begin::Prices-->
          <div class="form-group mb-11">
            <label class="font-size-h3 font-weight-bolder text-dark mb-7"
              >Price</label
            >
            <!--begin::Radio list-->
            <div class="radio-list">
              <label class="radio radio-lg mb-7">
                <input type="radio" name="price" />
                <span></span>
                <div class="font-size-lg text-dark-75 font-weight-bold">
                  All
                </div>
                <div class="ml-auto text-muted font-weight-bold">2047</div>
              </label>
              <label class="radio radio-lg mb-7">
                <input type="radio" name="price" />
                <span></span>
                <div class="font-size-lg text-dark-75 font-weight-bold">
                  0$ - 99$
                </div>
                <div class="ml-auto text-muted font-weight-bold">1403</div>
              </label>
              <label class="radio radio-lg mb-7">
                <input type="radio" name="price" />
                <span></span>
                <div class="font-size-lg text-dark-75 font-weight-bold">
                  100$ - 999$
                </div>
                <div class="ml-auto text-muted font-weight-bold">570</div>
              </label>
              <label class="radio radio-lg">
                <input type="radio" name="price" />
                <span></span>
                <div class="font-size-lg text-dark-75 font-weight-bold">
                  1000$ &amp; Above
                </div>
                <div class="ml-auto text-muted font-weight-bold">38</div>
              </label>
            </div>
            <!--end::Radio list-->
          </div>
          <!--end::Prices-->


          <button
            type="submit"
            class="btn btn-primary font-weight-bolder mr-2 px-8"
          >
            Submit
          </button>
          <button
            type="reset"
            @click="reset()"
            class="btn btn-clear font-weight-bolder text-muted px-8"
          >
            Reset
          </button>
        </form>
        <!--end::Form-->
      </div>
      <!--end::Body-->
    </div>
    <!--end::Forms Widget 15-->

</template>
