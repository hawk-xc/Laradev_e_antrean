<div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @script
        <script type="text/javascript">
            $(document).ready(function() {
                $wire.on('notify', (data) => {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: data.type,
                        title: data.message
                    });
                });

                $wire.on('show-delete', (data) => {
                    Swal.fire({
                        title: "Apakah anda yakin?",
                        text: "Status tiket akan diclose dan tidak dapat dipulihkan lagi!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        cancelButtonText: "tidak",
                        confirmButtonText: "Ya, tetap ubah"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('confirmDelete')
                            setTimeout(function() {
                                window.location.reload();
                            }, 4000);
                        }
                    });
                })

                $wire.on('confirmation', (data) => {
                    console.log(data[0].user.username);
                    var button = $('#closeButton');
                    button[0].click();
                    Swal.fire({
                        title: data[0].user.username + " to " + data[0].type,
                        text: data[0].message,
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        cancelButtonText: "batal",
                        confirmButtonText: "Ya, perbahrui user ini!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch(data[0].response)
                            setTimeout(function() {
                                window.location.reload();
                            }, 4000);
                        }
                    });
                })

                $wire.on('closeButton', () => {
                    var button = $('#closeButton');
                    var button2 = $('#closeModal');
                    button[0].click();
                    button2[0].click();
                })

                $wire.on('modals', (data) => {
                    const deviceIdForm = $('#deviceIdForm');
                    const deviceNameForm = $('#deviceNameForm');
                    const deviceYearForm = $('#deviceYearForm');
                    const driveLinkForm = $('#driveLinkForm');
                    const deviceLastUpdateForm = $('#deviceLastUpdateForm');

                    const originalDatetime = data.data.updated_at;

                    const dateTime = new Date(originalDatetime);

                    const pad = (num) => {
                        return num.toString().padStart(2, '0');
                    };

                    const formattedDatetime =
                        `${dateTime.getFullYear()}-${pad(dateTime.getMonth() + 1)}-${pad(dateTime.getDate())} ${pad(dateTime.getHours())}:${pad(dateTime.getMinutes())}:${pad(dateTime.getSeconds())}`;

                    const deviceId = data.data.id;
                    deviceIdForm.val(data.data.id);
                    deviceNameForm.val(data.data.device_name);
                    deviceYearForm.val(data.data.device_year);
                    driveLinkForm.val(data.data.drive_link);
                    deviceLastUpdateForm.val(formattedDatetime);
                });

                $wire.on('modals-ticket', (data) => {
                    const ticketIdForm = $('#ticketIdForm');
                    const deviceIdForm = $('#deviceIdForm');
                    const ticketLastUpdateForm = $('#ticketLastUpdateForm');
                    const ticketDescriptionForm =  $('#ticketDescriptionForm');

                    const originalDatetime = data.data.updated_at;

                    const dateTime = new Date(originalDatetime);

                    const pad = (num) => {
                        return num.toString().padStart(2, '0');
                    };

                    const formattedDatetime =
                        `${dateTime.getFullYear()}-${pad(dateTime.getMonth() + 1)}-${pad(dateTime.getDate())} ${pad(dateTime.getHours())}:${pad(dateTime.getMinutes())}:${pad(dateTime.getSeconds())}`;

                    // const deviceId = data.data.id;
                    ticketIdForm.val(data.data.id);
                    // deviceIdForm.val(data.data.id);
                    // deviceNameForm.val(data.data.device_name);
                    ticketLastUpdateForm.val(formattedDatetime);
                    ticketDescriptionForm.val(data.data.description);
                });

                $wire.on('refresh', () => {
                    setTimeout(function() {
                        window.location.reload();
                    }, 3000);
                })
            })
        </script>
    @endscript
</div>
