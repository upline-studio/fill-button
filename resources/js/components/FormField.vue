<template>
    <field-wrapper>
        <div class="w-full py-4 px-8">
        <loading-button type="button" class="btn btn-default btn-primary" @click="run" :processing="loading">
            {{ field.name }}
        </loading-button>
        </div>
    </field-wrapper>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    created() {
        console.log(this.field)
        for (const field of this.field.sourceFields) {
            Nova.$on(`${field}-change`, (value) => {
                this.fieldValues[field] = value
            })
        }
    },

    data() {
        return {
            loading: false,
            fieldValues: {...this.field.initialData}
        }
    },

    methods: {
        run() {
            this.loading = true;

            Nova.request()
                .post(
                    this.field.calculateUrl,
                    {
                        resourceId: this.resourceId,
                        fieldName: this.field.attribute,
                        data: this.fieldValues
                    }
                )
                .then(response => {
                    for(const [key, value] of Object.entries(response.data)){
                        Nova.$emit(`${key}-value`, value)
                    }
                    this.loading = false;
                })
                .catch(() => {
                    this.loading = false;
                });
        },

        fill() {
            // Doesn't send any data
        },
    },
}
</script>
