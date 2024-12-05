<script setup></script>

<template>
    <div class="cpi-input">
        <div class="mb-3 border rounded input-group">
            <button
                class="btn btn-light dropdown-toggle d-flex align-items-center cpi-drop"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >
                <span class="me-1">🇮🇳</span>
            </button>
            <div class="dropdown-menu w-100">
                <button
                    type="button"
                    class="dropdown-item"
                    data-cpi-icon="🇮🇳"
                    data-cpi-ext="+91"
                    data-cpi-min-length="10"
                    data-cpi-max-length="10"
                >
                    🇮🇳 India (+91)
                </button>
                <button
                    type="button"
                    class="dropdown-item"
                    data-cpi-icon="🇦🇪"
                    data-cpi-ext="+971"
                    data-cpi-min-length="8"
                    data-cpi-max-length="9"
                >
                    🇦🇪 United Arab Emirates (+971)
                </button>
            </div>
            <span
                class="bg-white border-0 input-group-text text-muted cpi-ext-txt"
                >+91</span
            >
            <input
                type="text"
                class="border-0 form-control phone-input flex-shrink-1"
                style="outline: none"
                pattern="[0-9]+"
                required
                minlength="10"
                maxlength="10"
                title="Enter a valid mobile number"
            />
        </div>
        <input type="hidden" class="country-code-input" />
    </div>
</template>
