<template>
    <canvas></canvas>
</template>

<script>
    var warehouse_datachart;

    export default {
        data() {
            return {
                record: {},
                errors: [],
            }
        },
        props: {
            type: {
                type: String,
                required: false,
                default: '',
            },
            title: {
                type: String,
                required: false,
                default: '',
            },
            data: {
                type: Array,
                required: false,
                default: [],
            },
            descriptions: {
                type: Array,
                required: false,
                default: '',
            },
            labels: {
                type: Array,
                required: false,
                default: [],
            },

        },
        mounted() {
            const vm = this;
            warehouse_datachart = new Chart(this.$el, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: '',
                        data: [],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1,
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: vm.title,
                        position: 'bottom'
                    },
                    tooltips: {
                        enabled: true,
                        mode: 'single',
                        callbacks: {
                            title: function (tooltipItem, data) {
                                return data.labels[tooltipItem[0].index];
                            },
                            label: function(tooltipItems, data) {
                                return "Total: " + tooltipItems.yLabel;
                            },
                            footer: function (tooltipItem, data) {
                                return '';
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
                            }
                        }]
                    }
                }
            });
        },
        watch: {
            data: function(data) {
                warehouse_datachart.config.data.datasets[0].data = data;
                warehouse_datachart.update();
            },
            labels: function(labels) {
                warehouse_datachart.config.data.labels = labels;
                warehouse_datachart.update();
            },
            title: function(title) {
                warehouse_datachart.config.options.title.text = title;
                warehouse_datachart.update();
            },
            type: function(type) {
                const vm = this;
                if (warehouse_datachart.config.type == type) {
                    warehouse_datachart.update();
                    return;
                }
                else if (type == 'bar') {
                    warehouse_datachart.destroy();
                    warehouse_datachart = new Chart(this.$el, {
                        type: type,
                        data: {
                            labels: this.labels,
                            datasets: [{
                                label: '',
                                data: this.data,
                                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(255, 159, 64, 0.2)'],
                                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(153, 102, 255, 1)', 'rgba(75, 192, 192, 1)', 'rgba(255, 159, 64, 1)'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            legend: {
                                display: false,
                            },
                            title: {
                                display: true,
                                text: this.title,
                                position: 'bottom'
                            },
                            tooltips: {
                                enabled: true,
                                mode: 'single',
                                callbacks: {
                                    title: function (tooltipItem, data) {
                                        return data.labels[tooltipItem[0].index];
                                    },
                                    label: function(tooltipItems, data) {
                                        return "Total: " + tooltipItems.yLabel;
                                    },
                                    footer: function (tooltipItem, data) {
                                        return vm.descriptions[tooltipItem[0].index];
                                    }
                                }
                            },
                            scales: {
                                yAxes: [{
                                    display: true,
                                    ticks: {
                                        beginAtZero: true,
                                    }
                                }]
                            }
                        }
                    });
                }
                else if ((type == 'doughnut') || (type == 'pie')) {
                    warehouse_datachart.destroy();
                    warehouse_datachart = new Chart(this.$el, {
                        type: type,
                        data: {
                            labels: this.labels,
                            datasets: [{
                                label: '',
                                data: this.data,
                                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(255, 159, 64, 0.2)'],
                                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(153, 102, 255, 1)', 'rgba(75, 192, 192, 1)', 'rgba(255, 159, 64, 1)'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            legend: {
                                display: true,
                                position: 'right'
                            },
                            title: {
                                display: true,
                                text: this.title,
                                position: 'bottom'
                            },
                            tooltips: {
                                enabled: true,
                                mode: 'single',
                                callbacks: {
                                    title: function (tooltipItem, data) {
                                        return data.labels[tooltipItem[0].index];
                                    },
                                    label: function(tooltipItems, data) {
                                        return "Total: " + tooltipItems.yLabel;
                                    },
                                    footer: function (tooltipItem, data) {
                                        return vm.descriptions[tooltipItem[0].index];
                                    }
                                }
                            }
                        }
                    });
                }
            },
        },
    };
</script>
