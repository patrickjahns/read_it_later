<template lang="pug">
    div
        form
            div.uk-align-right
                .uk-inline
                    span.uk-form-icon(uk-icon="icon:link")
                    input.uk-input.uk-form-width-large(v-model="url", name="url", placeholder="http://...")
                button.uk-button.uk-button-primary(@click="add") READ IT LATER

        table.uk-table.uk-table-striped
            thead
                tr
                    th title
                    th url
                    th date
                    th.uk-table-shrink action
            tbody
                tr(v-for="entry in entries")
                    td {{ entry.title }}
                    td {{ entry.url }}
                    td {{ entry.createdAt.date }}
                    td.uk-align-right.uk-margin-remove
                        a(@click="deleteEntry(entry.id)", uk-icon="icon:trash")
</template>

<script>
    export default {
        data: function () {
            return {
                entries: [],
                url: ""
            };
        },
        components: {},
        mounted() {
        	this.getEntries();
        },
        methods: {
            getEntries: function () {
                var that = this;
                $.ajax({
                    type: "GET",
                    url: OC.generateUrl('apps/read_it_later/list'),
                    success: function (data) {
                        that.entries = data;
                    }
                });
            },
            deleteEntry: function(id) {
				var that = this;
                $.ajax({
                    type: "DELETE",
                    url: OC.generateUrl('apps/read_it_later/delete/' + id),
                    success: function() {
						for (var i = 0, len = that.entries.length; i < len; i++) {
							if (that.entries[i].id == id) {
								that.entries.splice(i, 1);
								break;
                            }
						}
                    }
                });
            },
			add: function (event) {
				event.preventDefault();
				var that = this;
				$.ajax({
					type: "POST",
					url: OC.generateUrl('apps/read_it_later/add'),
					data: {
						url: this.url
					},
					success: function()  {
                        that.getEntries();
					}
				});
			}
        },
        computed: {},
        filter: {}
    }
</script>

<style scoped>
    form {
        overflow: hidden;
    }
</style>
