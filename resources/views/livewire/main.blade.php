<div>
    Hello {{ Auth::user()->name }}
    <div class="container">
        <div>
            <ul class="steps">
                <li class="step">Register and Login</li>
                <li class="step">Add your device</li>
                <li class="step">Registering new ticket</li>
                <li class="step">Notification</li>
            </ul>
        </div>
        <div>
            <div class="collapse collapse-plus bg-base-200">
                <input type="radio" name="my-accordion-3" checked="checked" />
                <div class="text-xl font-medium collapse-title">
                    Click to open this one and close others
                </div>
                <div class="collapse-content">
                    <p>hello</p>
                </div>
            </div>
            <div class="collapse collapse-plus bg-base-200">
                <input type="radio" name="my-accordion-3" />
                <div class="text-xl font-medium collapse-title">
                    Click to open this one and close others
                </div>
                <div class="collapse-content">
                    <p>hello</p>
                </div>
            </div>
            <div class="collapse collapse-plus bg-base-200">
                <input type="radio" name="my-accordion-3" />
                <div class="text-xl font-medium collapse-title">
                    Click to open this one and close others
                </div>
                <div class="collapse-content">
                    <p>hello</p>
                </div>
            </div>
        </div>
    </div>
    {{-- <iframe
        src="https://calendar.google.com/calendar/embed?height=600&wkst=1&ctz=Asia%2FJakarta&bgcolor=%23ffffff&showTitle=0&showNav=0&showTabs=0&src=d2FoeXV0cmljYWh5b25vNzc3QGdtYWlsLmNvbQ&src=Y2xhc3Nyb29tMTA4NjA1MTUzOTMwNzcxODEwMjk2QGdyb3VwLmNhbGVuZGFyLmdvb2dsZS5jb20&color=%23039BE5&color=%230047a8"
        style="border:solid 1px #777" width="800" height="600" frameborder="0" scrolling="no"></iframe> --}}

</div>
