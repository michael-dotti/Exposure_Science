<x-layout-menu-bar-private>
    <x-slot:title>
        Events
    </x-slot:title>
    <x-email-box> 
        <div class="mb-6">
            <h4 class="text-lg text-gray-800 font-bold pb-2 mb-4 border-b-2"> {{ $event->title}} </h4>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="{{ asset($event->creator->profile_photo_path) }}" alt="{{ $event->creator->name }}" class="rounded-full w-8 h-8 border border-gray-500">
                    <div class="flex flex-col ml-2">
                        <span class="text-sm font-semibold">{{ $event->creator->name}} {{ $event->creator->surname}}</span>
                        <span class="text-xs text-gray-400">From: {{ $event->creator->email }} </span>
                    </div>
                </div>
                <span class="text-sm text-gray-500">{{$event->created_at->format('M d, Y, h:i A')}}</span>
            </div>
            <div class="py-6 pl-2 text-gray-700">
                {{ $event->content}}
                <!-- 
                    <p>Hi John!</p>
                    <p class="mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                    <p class="mt-4">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <p class="mt-4">Sed ut perspiciatis unde omnis iste natus error sit:</p>
                    <ul class="ml-12 list-disc">
                        <li>voluptatem accusantium</li>
                        <li>doloremque laudantium</li>
                        <li>totam rem aperiam</li>
                        <li>eaque ipsa quae ab illo inventore veritatis</li>
                        <li>quasi architecto</li>
                    </ul>
                    <p class="mt-4">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur.</p>
                    <p class="mt-4">Regards,</p>
                    <p>Betty Garmon</p>
                -->
            </div>
            <div class="border-t-2 flex space-x-4 py-4">
                <div class="w-70 flex items-center py-2.5 px-2 border-2 border-gray-300 rounded-lg hover:bg-gray-200">
                    <div class="flex items-center">
                        <div class="w-10 flex items-center justify-center">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 121.83"><defs><style>.cls-1,.cls-2{fill-rule:evenodd;}.cls-2{fill:red;}.cls-3{fill:#fff;}</style></defs><path class="cls-1" d="M102.42,37H81.92a8.52,8.52,0,0,1-8.85-8.7V7.53H21a.58.58,0,0,0-.41.18.45.45,0,0,0-.18.42V113.71a.7.7,0,0,0,.18.41.51.51,0,0,0,.41.18h80.84c.18,0,.17-.09.26-.18s.34-.28.34-.41V37Zm7.47,79.08a5.77,5.77,0,0,1-5.76,5.76H18.66a5.77,5.77,0,0,1-5.76-5.76V5.76a5.7,5.7,0,0,1,1.69-4.07A5.77,5.77,0,0,1,18.66,0H76.9a4.22,4.22,0,0,1,2.46.82l29.75,30.12a2.57,2.57,0,0,1,.78,2.6v82.53ZM80,27.69,79.57,9.63,100.66,31l-18.14-.81A2.4,2.4,0,0,1,80,27.69Z"></path><path class="cls-2" d="M6.71,46.28H116.17A6.73,6.73,0,0,1,122.88,53v45.1a6.73,6.73,0,0,1-6.71,6.71H6.71A6.73,6.73,0,0,1,0,98.09V53a6.73,6.73,0,0,1,6.71-6.71Z"></path><path class="cls-3" d="M16.33,59.78h16.2c3.53,0,6.17.83,7.94,2.51s2.63,4.08,2.63,7.18a9.71,9.71,0,0,1-2.88,7.47c-1.91,1.8-4.84,2.69-8.77,2.69H26.1V91.3H16.33V59.78ZM26.1,73.25h2.4a6.22,6.22,0,0,0,4-1,3.17,3.17,0,0,0,1.14-2.51,3.51,3.51,0,0,0-1-2.52c-.66-.69-1.91-1-3.75-1H26.1v7ZM48.3,59.78H62.78a17.47,17.47,0,0,1,6.92,1.16,11.23,11.23,0,0,1,4.35,3.33,13.66,13.66,0,0,1,2.49,5,23.36,23.36,0,0,1,.78,6.11,21.16,21.16,0,0,1-1.15,7.84A13,13,0,0,1,73,87.93a10.38,10.38,0,0,1-4.39,2.51,22.39,22.39,0,0,1-5.81.86H48.3V59.78ZM58,66.91V84.13h2.4a10.16,10.16,0,0,0,4.36-.68,4.65,4.65,0,0,0,2-2.36,14.84,14.84,0,0,0,.73-5.48q0-5-1.63-6.85c-1.09-1.23-2.91-1.85-5.44-1.85Zm24.43-7.13h24.09v6.78H92.24v5.5h12.24v6.39H92.24V91.3H82.46V59.78Z"></path></svg>
                        </div>
                        <div class="w-48 ml-2 flex flex-col">
                            <a href="#" class="text-sm text-gray-700 font-bold truncate">Terms and Conditions.pdf</a>
                            <span class="text-gray-500 text-xs">1.5 MB</span>
                        </div>
                    </div>
                    <button class="w-6 flex items-center justify-center" title="Download">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-500 hover:text-gray-600 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                    </button>
                </div>
                <div class="w-70 flex items-center py-2.5 px-2 border-2 border-gray-300 rounded-lg hover:bg-gray-200">
                    <div class="flex items-center">
                        <div class="w-10 flex items-center justify-center">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve"><style type="text/css">.st0{fill:#41A5EE;} .st1{fill:#2B7CD3;} .st2{fill:#185ABD;} .st3{fill:#103F91;} .st4{opacity:0.1;enable-background:new ;} .st5{opacity:0.2;enable-background:new ;} .st6{fill:url(#SVGID_1_);} .st7{fill:#FFFFFF;}</style><path class="st0" d="M490.17,19.2H140.9c-12.05,0-21.83,9.72-21.83,21.7l0,0v96.7l202.42,59.2L512,137.6V40.9	C512,28.91,502.23,19.2,490.17,19.2L490.17,19.2z"></path><path class="st1" d="M512,137.6H119.07V256l202.42,35.52L512,256V137.6z"></path><path class="st2" d="M119.07,256v118.4l190.51,23.68L512,374.4V256H119.07z"></path><path class="st3" d="M140.9,492.8h349.28c12.05,0,21.83-9.72,21.83-21.7l0,0v-96.7H119.07v96.7	C119.07,483.09,128.84,492.8,140.9,492.8L140.9,492.8z"></path><path class="st4" d="M263.94,113.92H119.07v296h144.87c12.04-0.04,21.79-9.73,21.83-21.7v-252.6	C285.73,123.65,275.98,113.96,263.94,113.92z"></path><path class="st5" d="M252.04,125.76H119.07v296h132.97c12.04-0.04,21.79-9.73,21.83-21.7v-252.6	C273.82,135.49,264.07,125.8,252.04,125.76z"></path><path class="st5" d="M252.04,125.76H119.07v272.32h132.97c12.04-0.04,21.79-9.73,21.83-21.7V147.46	C273.82,135.49,264.07,125.8,252.04,125.76z"></path><path class="st5" d="M240.13,125.76H119.07v272.32h121.06c12.04-0.04,21.79-9.73,21.83-21.7V147.46	C261.91,135.49,252.17,125.8,240.13,125.76z"></path><linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="45.8183" y1="-1083.4916" x2="216.1361" y2="-788.5082" gradientTransform="matrix(1 0 0 1 0 1192)"><stop offset="0" style="stop-color:#2368C4"></stop><stop offset="0.5" style="stop-color:#1A5DBE"></stop><stop offset="1" style="stop-color:#1146AC"></stop></linearGradient><path class="st6" d="M21.83,125.76h218.3c12.05,0,21.83,9.72,21.83,21.7v217.08c0,11.99-9.77,21.7-21.83,21.7H21.83	C9.77,386.24,0,376.52,0,364.54V147.46C0,135.48,9.77,125.76,21.83,125.76z"></path><path class="st7" d="M89.56,292.21c0.43,3.35,0.71,6.26,0.85,8.76h0.5c0.19-2.37,0.59-5.22,1.19-8.56c0.6-3.34,1.15-6.16,1.63-8.47	l22.96-98.49h29.68l23.81,97.01c1.38,6.03,2.37,12.15,2.96,18.3h0.39c0.44-5.97,1.27-11.9,2.48-17.76l18.99-97.6h27.02	l-33.36,141.13H157.1l-22.62-93.47c-0.65-2.69-1.4-6.2-2.23-10.53s-1.33-7.48-1.54-9.47h-0.39c-0.26,2.3-0.77,5.71-1.54,10.23	c-0.76,4.52-1.37,7.87-1.83,10.04l-21.27,93.17h-32.1L40.04,185.46h27.5l20.68,98.69C88.7,286.17,89.14,288.87,89.56,292.21z"></path></svg>
                        </div>
                        <div class="w-48 ml-2 flex flex-col">
                            <a href="#" class="text-sm text-gray-700 font-bold truncate">Contract Proposal.docx</a>
                            <span class="text-gray-500 text-xs">3.1 MB</span>
                        </div>
                    </div>
                    <button class="w-6 flex items-center justify-center" title="Download">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-500 hover:text-gray-600 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="mt-8 flex items-center space-x-4">
                <button class="w-32 flex items-center justify-center space-x-2 py-1.5 text-gray-600 border border-gray-400 rounded-lg hover:bg-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.707 3.293a1 1 0 010 1.414L5.414 7H11a7 7 0 017 7v2a1 1 0 11-2 0v-2a5 5 0 00-5-5H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Reply</span>
                </button>
                <button class="w-32 flex items-center justify-center space-x-2 py-1.5 text-gray-600 border border-gray-400 rounded-lg hover:bg-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                    <span>Forward</span>    
                </button>
            </div>
        </div>
    </x-email-box>
</x-layout-menu-bar-private>