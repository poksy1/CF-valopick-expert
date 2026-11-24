const ValoAssets = {
    agents: {},
    agentIcons: {},
    agentAbilities: {},
    maps: {},
    loaded: false,

    normalize(str) {
        return (str || '').toLowerCase().replace(/[^a-z0-9]/g, '');
    },

    async init() {
        if (this.loaded) return;

        const cached = localStorage.getItem('valo_assets_cache_v5');
        if (cached) {
            try {
                const parsed = JSON.parse(cached);
                if (parsed.agents && Object.keys(parsed.agents).length > 0) {
                    this.agents = parsed.agents;
                    this.agentIcons = parsed.agentIcons || {};
                    this.agentAbilities = parsed.agentAbilities || {};
                    this.maps = parsed.maps || {};
                    this.loaded = true;
                    return;
                }
            } catch (e) {}
        }

        try {
            const [resAgents, resMaps] = await Promise.all([
                fetch('https://valorant-api.com/v1/agents?isPlayableCharacter=true'),
                fetch('https://valorant-api.com/v1/maps')
            ]);

            const dataAgents = await resAgents.json();
            const dataMaps = await resMaps.json();

            if (dataAgents.status === 200) {
                dataAgents.data.forEach(a => {
                    const key = this.normalize(a.displayName);
                    this.agents[key] = a.fullPortrait || a.displayIcon;
                    this.agentIcons[key] = a.displayIcon;

                    // Ambil 4 ability utama yang memiliki ikon (skip Passive)
                    this.agentAbilities[key] = (a.abilities || [])
                        .filter(ab => ab.displayIcon && ab.slot !== 'Passive')
                        .map(ab => ({
                            slot: ab.slot,
                            name: ab.displayName,
                            icon: ab.displayIcon
                        }));
                });
            }

            if (dataMaps.status === 200) {
                dataMaps.data.forEach(m => {
                    const key = this.normalize(m.displayName);
                    if (m.splash) {
                        this.maps[key] = {
                            splash: m.splash,
                            minimap: m.displayIcon || ''
                        };
                    }
                });
            }

            if (Object.keys(this.agents).length > 0) {
                localStorage.setItem('valo_assets_cache_v5', JSON.stringify({
                    agents: this.agents,
                    agentIcons: this.agentIcons,
                    agentAbilities: this.agentAbilities,
                    maps: this.maps
                }));
            }
            this.loaded = true;
        } catch (err) {
            console.warn('Mode offline: menggunakan fallback gambar lokal.', err);
        }
    },

    getAgentImage(agentName) {
        const key = this.normalize(agentName);
        return this.agents[key] || `assets/img/agents/${key}.webp`;
    },

    getAgentIcon(agentName) {
        const key = this.normalize(agentName);
        return this.agentIcons[key] || `assets/img/agents/${key}.webp`;
    },

    getAgentAbilities(agentName) {
        const key = this.normalize(agentName);
        return this.agentAbilities[key] || [];
    },

    getMapImage(mapName) {
        const key = this.normalize(mapName);
        return (this.maps[key] && this.maps[key].splash) || `assets/img/maps/${key}.webp`;
    },

    getMapMinimap(mapName) {
        const key = this.normalize(mapName);
        return (this.maps[key] && this.maps[key].minimap) || `assets/img/maps/${key}_minimap.webp`;
    }
};