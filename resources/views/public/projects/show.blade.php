<x-layout-public>

    <x-slot:title>
        {{ $project->title }}
    </x-slot:title>

    <x-slot:heading>
        <div class="py-5 text-center">
            <h1 class="text-3xl font-bold text-amber-300">
                {{ $project->title }}
            </h1>
        </div>
    </x-slot:heading>

    <section class="py-8">
        <div class="mx-auto max-w-6xl px-4 lg:px-6">

            <div class="mb-7">
                <x-public-botton-back
                    title="Torna ai progetti"
                    :href="route('public.projects.index')"
                />
            </div>

            <article class="overflow-hidden rounded-xl border border-slate-700 bg-gray-800 shadow-md">

                {{-- Informazioni principali --}}
                <div class="p-6 md:p-8">

                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-amber-400/20 bg-amber-400/10 text-amber-300">
                            <i
                                class="fa-solid fa-diagram-project"
                                aria-hidden="true"
                            ></i>
                        </div>

                        <div>
                            <h2 class="text-xl font-bold text-white">
                                Informazioni sul progetto
                            </h2>
                        </div>
                    </div>

                    <div class="mt-7 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                        {{-- Stato --}}
                        <div class="rounded-xl border border-white/5 bg-slate-900/50 p-4">
                            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                <i
                                    class="fa-solid fa-circle-check text-cyan-400"
                                    aria-hidden="true"
                                ></i>

                                Stato
                            </div>

                            <p class="mt-3 text-base font-bold text-white">
                                {{ $project->status->label() }}
                            </p>
                        </div>

                        {{-- Data di avvio --}}
                        <div class="rounded-xl border border-white/5 bg-slate-900/50 p-4">
                            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                <i
                                    class="fa-regular fa-calendar text-cyan-400"
                                    aria-hidden="true"
                                ></i>

                                Data di avvio
                            </div>

                            <p class="mt-3 text-base font-bold text-white">
                                @if ($project->start_date)
                                    {{ \Illuminate\Support\Carbon::parse($project->start_date)->format('d/m/Y') }}
                                @else
                                    Non indicata
                                @endif
                            </p>
                        </div>

                        {{-- Data di fine --}}
                        <div class="rounded-xl border border-white/5 bg-slate-900/50 p-4">
                            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                <i
                                    class="fa-regular fa-calendar-check text-cyan-400"
                                    aria-hidden="true"
                                ></i>

                                Data di fine
                            </div>

                            <p class="mt-3 text-base font-bold text-white">
                                @if ($project->end_date)
                                    {{ \Illuminate\Support\Carbon::parse($project->end_date)->format('d/m/Y') }}
                                @else
                                    Non indicata
                                @endif
                            </p>
                        </div>

                        {{-- Ente finanziatore --}}
                        <div class="rounded-xl border border-white/5 bg-slate-900/50 p-4">
                            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                <i
                                    class="fa-solid fa-building-columns text-cyan-400"
                                    aria-hidden="true"
                                ></i>

                                Finanziato da
                            </div>

                            <p class="mt-3 break-words text-base font-bold text-white">
                                {{ $project->funding_agency ?: 'Non indicato' }}
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Ricercatori partecipanti --}}
				<div class="border-t border-slate-700 bg-slate-900/30 p-6 md:p-8">

					<div class="flex items-center gap-3">
						<div class="flex h-10 w-10 items-center justify-center rounded-full bg-cyan-500/10 text-cyan-400">
							<i
								class="fa-solid fa-users"
								aria-hidden="true"
							></i>
						</div>

						<h2 class="text-xl font-bold text-white">
							@if ($project->users->count() === 1)
								Ricercatore coinvolto
							@else
								Ricercatori coinvolti
							@endif
						</h2>
					</div>

					@if ($project->users->isNotEmpty())

						<div class="mt-5 grid gap-3 md:grid-cols-2">

							@foreach ($project->users as $user)
								<a
									href="{{ route('public.users.show', $user) }}"
									class="group flex items-center gap-4 rounded-xl
										border border-slate-700 bg-gray-800
										px-4 py-3 transition duration-200
										hover:border-cyan-400/30
										hover:bg-slate-700/50"
								>
									{{-- Icona ricercatore --}}
									<div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-cyan-500/10 text-cyan-400">
										<i
											class="fa-solid fa-user"
											aria-hidden="true"
										></i>
									</div>

									{{-- Informazioni ricercatore --}}
									<div class="min-w-0 flex-1">
										<p class="truncate font-semibold text-white">
											{{ $user->name }} {{ $user->surname }}
										</p>

										<p class="mt-0.5 text-xs text-gray-400">
											Visualizza il profilo
										</p>
									</div>

									{{-- Freccia --}}
									<i
										class="fa-solid fa-chevron-right text-xs text-gray-500 transition
											group-hover:translate-x-1 group-hover:text-cyan-400"
										aria-hidden="true"
									></i>
								</a>
							@endforeach

						</div>

					@else

						<p class="mt-5 text-sm text-gray-400">
							Nessun ricercatore associato al progetto.
						</p>

					@endif

				</div>

                {{-- Descrizione --}}
                <div class="border-t border-slate-700 bg-slate-900/50 p-6 md:p-8">

                    <div class="flex items-center gap-3">
                        <i
                            class="fa-solid fa-align-left text-amber-300"
                            aria-hidden="true"
                        ></i>

                        <h2 class="text-xl font-bold text-white">
                            In cosa consiste il progetto
                        </h2>
                    </div>

                    <div class="mt-5 text-sm leading-7 text-gray-300 [overflow-wrap:anywhere]">
                        {!! $project->description !!}
                    </div>

                </div>

            </article>

        </div>
    </section>

</x-layout-public>