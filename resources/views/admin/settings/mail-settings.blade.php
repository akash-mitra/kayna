<div class="w-full">
        @if(session()->has('message'))
                        <div class="bg-green-lightest text-green text-sm py-4 px-6 mb-6 border-b border-green">{{ session('message') }}</div>
        @endif

        <div class="px-6 py-6">
                <h3 class="font-bold text-indigo">Email Setup</h3>
                <p class="py-2 text-grey-dark">Provide the SMTP details of your email account so that this website can automatically send email notifications to users.</p>

                <div class="w-full lg:w-3/4 my-4">
                    <div class="my-4 bg-grey-lighter p-4 rounded mb-4">
                            <label class="block text-gray-dark text-sm font-bold mb-2" for="mail_service">
                                    Choose Your Mail Service Provider
                            </label>

                            <select v-model="mail_service" id="mail_service" class="w-full border p-3">
                                <option disabled value="">Please select one</option>
                                <option value="smtp">SMTP (General)</option>
                                <option value="google">Google (SMTP)</option>
                                <option disabled value="api">API</option>
                            </select>
                    </div>

                    

                    <div v-if="mail_service==='api'">
                        <h4 class="py-2 text-grey-dark font-light">API Settings</h4>
                    </div>

                    <div v-if="mail_service==='google'">
                        
                        <h4 class="py-2 text-grey-dark font-light">Google SMTP Settings</h4>

                        <div class="w-full my-4">
                                <label class="block text-gray-dark text-sm font-bold mb-2" for="mail_name">
                                        Name
                                </label>
                                <input type="text" v-model="mail_name" id="mail_name" class="w-full border p-3 rounded" placeholder="e.g. John Doe">
                        </div>

                        <div class="w-full my-4">
                                <label class="block text-gray-dark text-sm font-bold mb-2" for="mail_username">
                                        Username
                                </label>
                                <input type="email" v-model="mail_username" id="mail_username" class="w-full border p-3 rounded" placeholder="smtp.google.com">
                        </div>

                        <div class="w-full my-4">
                                <label class="block text-gray-dark text-sm font-bold mb-2" for="mail_password">
                                        Password
                                </label>
                                <input type="password" v-model="mail_password" id="mail_password" class="w-full border p-3 rounded" placeholder="smtp.google.com">
                        </div>

                    </div>

                    <div v-if="mail_service==='smtp'" class="py-2">
                        <h4 class="py-2 text-grey-dark font-light">General SMTP Settings</h4>

                        <div class="w-full sm:flex">
                            <div class="w-full my-4">
                                <label class="block text-gray-dark text-sm font-bold mb-2" for="mail_host">
                                        Host
                                </label>
                                <input type="text" v-model="mail_host" id="mail_host" class="w-full border p-3 rounded" placeholder="smtp.google.com">
                            </div>
                            <div class="sm:ml-2 my-4">
                                <label class="block text-gray-dark text-sm font-bold mb-2" for="mail_port">
                                        Host Port
                                </label>
                                <input type="text" v-model="mail_port" id="mail_port" class="w-full max-w-sm border p-3 rounded" placeholder="587">
                            </div>
                        </div>

                        <div class="w-full my-4">
                                <label class="block text-gray-dark text-sm font-bold mb-2" for="mail_name">
                                        Name
                                </label>
                                <input type="text" v-model="mail_name" id="mail_name" class="w-full border p-3 rounded" placeholder="e.g. Mr. John Doe">
                        </div>

                        <div class="w-full my-4">
                                <label class="block text-gray-dark text-sm font-bold mb-2" for="mail_username">
                                        Username
                                </label>
                                <input type="email" v-model="mail_username" id="mail_username" class="w-full border p-3 rounded" placeholder="john@example.com">
                        </div>

                        <div class="w-full my-4">
                                <label class="block text-gray-dark text-sm font-bold mb-2" for="mail_password">
                                        Password
                                </label>
                                <input type="password" v-model="mail_password" id="mail_password" class="w-full border p-3 rounded" placeholder="****">
                        </div>

                        <div class="w-full my-4">
                            <label class="block text-gray-dark text-sm font-bold mb-2" for="mail_encryption">
                                    Encryption
                            </label>

                            <select v-model="mail_encryption" id="mail_encryption" class="w-full border p-3">
                                <option disabled value="">Please select one</option>
                                <option value="tls">TLS</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div>

                        <div class="w-full block my-4">
                                <button type="button" @click="update(['mail_service', 'mail_host', 'mail_port', 'mail_name', 'mail_username', 'mail_password', 'mail_encryption'])" class="px-4 py-2 bg-green text-white rounded shadow hover:bg-green-dark">Save</button>
                        </div>
                </div>
        </div>
</div>