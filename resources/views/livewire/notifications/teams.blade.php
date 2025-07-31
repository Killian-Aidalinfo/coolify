<div>
    <x-slot:title>
        Notifications | Coolify
    </x-slot>
    <x-notification.navbar />
    <form wire:submit='submit' class="flex flex-col gap-4 pb-4">
        <div class="flex items-center gap-2">
            <h2>Microsoft Teams</h2>
            <x-forms.button type="submit">
                Save
            </x-forms.button>
            @if ($teamsEnabled)
                <x-forms.button class="normal-case dark:text-white btn btn-xs no-animation btn-primary"
                    wire:click="sendTestNotification">
                    Send Test Notification
                </x-forms.button>
            @else
                <x-forms.button disabled class="normal-case dark:text-white btn btn-xs no-animation btn-primary">
                    Send Test Notification
                </x-forms.button>
            @endif
        </div>
        <div class="w-32">
            <x-forms.checkbox instantSave="instantSaveTeamsEnabled" id="teamsEnabled" label="Enabled" />
        </div>
        <x-forms.input type="password"
            helper="Create a Microsoft Teams Incoming Webhook. <br><a class='inline-block underline dark:text-white' href='https://learn.microsoft.com/en-us/microsoftteams/platform/webhooks-and-connectors/how-to/add-incoming-webhook' target='_blank'>Create Teams Webhook</a>"
            required id="teamsWebhookUrl" label="Webhook URL" />
    </form>
    <h2 class="mt-4">Notification Settings</h2>
    <p class="mb-4">
        Select events for which you would like to receive Microsoft Teams notifications.
    </p>
    <div class="flex flex-col gap-4 max-w-2xl">
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Deployments</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox instantSave="saveModel" id="deploymentSuccessTeamsNotifications"
                    label="Deployment Success" />
                <x-forms.checkbox instantSave="saveModel" id="deploymentFailureTeamsNotifications"
                    label="Deployment Failure" />
                <x-forms.checkbox instantSave="saveModel"
                    helper="Send a notification when a container status changes. It will notify for Stopped and Restarted events of a container."
                    id="statusChangeTeamsNotifications" label="Container Status Changes" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Backups</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox instantSave="saveModel" id="backupSuccessTeamsNotifications" label="Backup Success" />
                <x-forms.checkbox instantSave="saveModel" id="backupFailureTeamsNotifications" label="Backup Failure" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Scheduled Tasks</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox instantSave="saveModel" id="scheduledTaskSuccessTeamsNotifications"
                    label="Scheduled Task Success" />
                <x-forms.checkbox instantSave="saveModel" id="scheduledTaskFailureTeamsNotifications"
                    label="Scheduled Task Failure" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Server</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox instantSave="saveModel" id="dockerCleanupSuccessTeamsNotifications"
                    label="Docker Cleanup Success" />
                <x-forms.checkbox instantSave="saveModel" id="dockerCleanupFailureTeamsNotifications"
                    label="Docker Cleanup Failure" />
                <x-forms.checkbox instantSave="saveModel" id="serverDiskUsageTeamsNotifications"
                    label="Server Disk Usage" />
                <x-forms.checkbox instantSave="saveModel" id="serverReachableTeamsNotifications"
                    label="Server Reachable" />
                <x-forms.checkbox instantSave="saveModel" id="serverUnreachableTeamsNotifications"
                    label="Server Unreachable" />
                <x-forms.checkbox instantSave="saveModel" id="serverPatchTeamsNotifications" label="Server Patching" />
            </div>
        </div>
    </div>
</div>