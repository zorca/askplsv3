<template>
    <card class="flex flex-col items-center justify-center">
        <div class="px-3 py-3">
            <h1 class="text-center text-3xl text-80 font-light">Workspaces</h1><br>

            <h2 v-if="topics.length < 1"  class="font-light">No workspace Created. You won't be able to use Private review feature of AskPls.</h2>

            <div v-if="topics.length > 0" >
                <div >

                    <button @click="workspaceshow" class="btn btn-default">New Workspace </button>
 
                    <table  class="table w-full">
                        <thead>
                            <tr>
                                <th class="text-left">Workspace</th>
                                <th class="text-left">URL</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="topic in topics" >
                                <td>{{ topic.workspace }}</td>
                                <td>{{ topic.url }}</td> 
                                <td><a class="btn btn-default btn-default" href="/join">Use</a></td>
                            </tr>
                        </tbody>
                    </table>
                                        

                </div>

            </div>
      
            
        </div>
    </card>
</template>

<script>

import Show from './Show';

export default {
    props: [
        'card',    
    ],
    data: () => {
            return {

                id:"", 
                inpId: "", 
                topic: "",
                topics: [],

                } 
            },

    mounted() {
        axios.get('/workspace/get' )
                    .then(response => {
    
                        this.topics = response.data; 

                    });
    },
    methods: { 
        workspaceshow:function(){

            Nova.request().post('/nova-vendor/workspace/show');

        }
    }
}
</script>
