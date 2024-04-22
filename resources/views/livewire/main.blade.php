<div>
    <h2 class="text-xl font-semibold">Hello {{ Auth::user()->name }}</h2>

    @if ($tickets->isEmpty())
        <div class="container flex justify-center w-full p-5 align-middle max-sm:flex-col max-sm:gap-5 md:flex-row">
            <ul class="flex flex-col items-center justify-center flex-1 align-middle timeline timeline-vertical">
                <li>
                    <div class="timeline-start timeline-box">Register and Login</div>
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <hr />
                </li>
                <li>
                    <hr />
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-end timeline-box">Add your device</div>
                    <hr />
                </li>
                <li>
                    <hr />
                    <div class="timeline-start timeline-box">Registering new ticket</div>
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <hr />
                </li>
                <li>
                    <hr />
                    <div class="timeline-end timeline-box">Get notification</div>
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </li>
            </ul>
            <div class="flex-1">
                <div id="my-accordion" class="border collapse collapse-arrow border-base-300">
                    <input type="radio" name="my-accordion-2" checked="checked" />
                    <div class="text-xl font-medium collapse-title">
                        Register and Login
                    </div>
                    <div class="collapse-content">
                        <p>
                            Before you can add devices and add ticket queues, you need to register an account and create
                            an
                            account with valid credentials, we will not share your data.
                        </p>
                    </div>
                </div>
                <div id="my-accordion" class="border collapse collapse-arrow border-base-300">
                    <input type="radio" name="my-accordion-2" />
                    <div class="text-xl font-medium collapse-title">
                        Add your device
                    </div>
                    <div class="collapse-content">
                        <p>
                            You need to add the device you have to be able to create a new ticket queue, make sure the
                            data
                            you input is correct
                        </p>
                    </div>
                </div>
                <div id="my-accordion" class="border collapse collapse-arrow border-base-300">
                    <input type="radio" name="my-accordion-2" />
                    <div class="text-xl font-medium collapse-title">
                        Registering new ticket
                    </div>
                    <div class="collapse-content">
                        <p>
                            If you have registered your device, the next step is to register a ticket, where this ticket
                            will then be processed by our helpdesk team and technicians, you can also see activity
                            history
                            and other information on the ticket page, please remember the processing rules are 3x24
                            hours
                            from the start of the ticket made
                        </p>
                    </div>
                </div>
                <div id="my-accordion" class="border collapse collapse-arrow border-base-300">
                    <input type="radio" name="my-accordion-2" />
                    <div class="text-xl font-medium collapse-title">
                        Get notification
                    </div>
                    <div class="collapse-content">
                        <p>
                            When the repair process is complete, our team will send a notification to the customer via
                            WhatsApp number and email address, make sure to always regularly check notifications if the
                            ticket status goes into repair.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- <iframe
        src="https://calendar.google.com/calendar/embed?height=600&wkst=1&ctz=Asia%2FJakarta&bgcolor=%23ffffff&showTitle=0&showNav=0&showTabs=0&src=d2FoeXV0cmljYWh5b25vNzc3QGdtYWlsLmNvbQ&src=Y2xhc3Nyb29tMTA4NjA1MTUzOTMwNzcxODEwMjk2QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&color=%23039BE5&color=%230047a8"
        style="border:solid 1px #777" width="800" height="600" frameborder="0" scrolling="no"></iframe> --}}

</div>
