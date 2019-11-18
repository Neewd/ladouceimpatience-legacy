<template>
	<section>
		<section id="hero">
			<img src="img/banniere.jpg" class="w-full" />
		</section>
		<section id="decouverte" class="flex items-center justify-center flex-col my-16">
			<span class="font-primary font-bold uppercase text-3xl tracking-wide inline-block align-middle">Découvrez vite...</span>
			<div class="underline font-secondary flex flex-row w-88 justify-between mb-6 -mt-2">
				<p class="">Vos personnalisables</p>
				<p class="">Nos éditions limités</p>
			</div>
			
			<div class="flex flex-row w-full px-68">
				<div class="w-1/3 px-4">
					<img src="img/petite_attention.jpg" class="" />
					<div class="h-16 bg-secondary w-full flex flex-col justify-center items-center">
						<p class="font-primary font-bold text-base text-white uppercase">La petite attention</p>
						<p class="font-secondary text-white -mt-2"> 79€</p>
					</div>
				</div>
				<div class="w-1/3 px-4">
					<img src="img/irresistible.jpg"/>
					<div class="h-16 bg-secondary w-full flex flex-col justify-center items-center">
						<p class="font-primary font-bold text-base text-white uppercase">L'irresistible</p>
						<p class="font-secondary text-white -mt-2"> 150€</p>
					</div>
				</div>
				<div class="w-1/3 px-4">
					<img src="img/exceptionnel.jpg" class="" />
					<div class="h-16 bg-secondary w-full flex flex-col justify-center items-center">
						<p class="font-primary font-bold text-base text-white uppercase">L'exceptionnel</p>
						<p class="font-secondary text-white -mt-2"> 300€</p>
					</div>
				</div>
			</div>
		</section>
		<section id="selections" class="flex items-center justify-center flex-col my-16">
			<span class="font-primary font-bold uppercase text-3xl tracking-wide inline-block align-middle">Nos séléctions</span>
			<div id="firstRow" class="w-full px-68 h-104 flex flex-row mb-4">
				<div class="w-1/4 px-4 flex flex-col">
					<div class="bg-primary h-1/2 mb-4">
						
					</div>
					<div class="bg-third h-1/2 flex items-center justify-center text-white flex-col">
						<p>Pour</p>
						<p>Madame</p>
					</div>
				</div>
				<div class="w-2/4 bg-primary">
					
				</div>
				<div class="w-1/4 px-4 flex flex-col">
					<div class="bg-third h-1/2 flex items-center justify-center text-white flex-col">
						<p>Sélection</p>
						<button>Voir plus</button>
					</div>
					<div class="bg-primary h-1/2 mt-4">
						
					</div>
				</div>
			</div>
			<div id="secondRow" class="w-full px-68 h-104 flex flex-row">
				<div class="w-1/2 px-4 flex flex-col">
					<div class="h-2/3 bg-secondary">
						
					</div>
					<div class="h-1/3 flex flex-row mt-4">
						<div class="w-1/2 ">
							Sélection
							<button>Voir plus</button>
						</div>
						<div class="w-1/2 ml-4 bg-red-600">
							
						</div>
					</div>
				</div>
				<div class="w-1/2 px-4 flex flex-col">
					<div class="h-1/3 flex flex-row">
						<div class="w-1/2 mx-2">
							Sélection
							<button>Voir plus</button>
						</div>
						<div class="w-1/2 ml-4 bg-red-600">
							
						</div>
					</div>
					<div class="h-2/3 bg-secondary mt-4">
						
					</div>
				</div>
			</div>
		</section>
		<section id="socials" >
			<p class="text-3xl">@vous.paris</p>
		</section>
	</section>
</template>

<script>
	export default {
		data: function() {
			return {
				
			};
		},
		computed: {
			
		}
	};
</script>